<?php declare(strict_types=1);

namespace Goksagun\Collection\Test;

use Goksagun\Collection\StringCollection;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
#[UsesClass(StringCollection::class)]
class StringCollectionTest extends TestCase
{
    public function testShouldInstantiate()
    {
        $this->assertInstanceOf(StringCollection::class, new StringCollection());
    }

    public function testShouldSuccessWhenProvideStringItem()
    {
        $stringCollection = new StringCollection('item1');

        $this->assertContainsOnly('string', $stringCollection->all());
    }

    public function testShouldSuccessWhenProvideMultipleStringItems()
    {
        $stringCollection = new StringCollection('item1', 'item2', 'item3');

        $this->assertContainsOnly('string', $stringCollection->all());
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideIntItem()
    {
        $this->expectException(\TypeError::class);

        new StringCollection(1);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideFloatItem()
    {
        $this->expectException(\TypeError::class);

        new StringCollection(1.1);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideBoolItem()
    {
        $this->expectException(\TypeError::class);

        new StringCollection(true);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideArrayItem()
    {
        $this->expectException(\TypeError::class);

        new StringCollection([]);
    }
}