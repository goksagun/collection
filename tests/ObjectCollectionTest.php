<?php declare(strict_types=1);

namespace Goksagun\Collection\Test;

use Goksagun\Collection\ObjectCollection;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
#[UsesClass(ObjectCollection::class)]
class ObjectCollectionTest extends TestCase
{
    public function testShouldInstantiate()
    {
        $this->assertInstanceOf(ObjectCollection::class, new ObjectCollection());
    }

    public function testShouldSuccessWhenProvideObjectItem()
    {
        $objectCollection = new ObjectCollection(new \stdClass());

        $this->assertContainsOnly('object', $objectCollection->all());
    }

    public function testShouldSuccessWhenProvideMultipleObjectItems()
    {
        $objectCollection = new ObjectCollection(new \stdClass(), new \stdClass(), new \stdClass());

        $this->assertContainsOnly('object', $objectCollection->all());
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideIntItem()
    {
        $this->expectException(\TypeError::class);

        new ObjectCollection(1);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideFloatItem()
    {
        $this->expectException(\TypeError::class);

        new ObjectCollection(1.1);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideBoolItem()
    {
        $this->expectException(\TypeError::class);

        new ObjectCollection(true);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideStringItem()
    {
        $this->expectException(\TypeError::class);

        new ObjectCollection('item1');
    }
}