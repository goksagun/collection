<?php declare(strict_types=1);

namespace Goksagun\Collection\Test;

use Goksagun\Collection\FloatCollection;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
#[UsesClass(FloatCollection::class)]
class FloatCollectionTest extends TestCase
{
    public function testShouldInstantiate()
    {
        $this->assertInstanceOf(FloatCollection::class, new FloatCollection());
    }

    public function testShouldSuccessWhenProvideFloatItem()
    {
        $floatCollection = new FloatCollection(1.1);

        $this->assertContainsOnly('float', $floatCollection->all());
    }

    public function testShouldSuccessWhenProvideMultipleFloatItems()
    {
        $floatCollection = new FloatCollection(1.1, 2.2, 3.3);

        $this->assertContainsOnly('float', $floatCollection->all());
    }

//    public function testShouldThrowTypeErrorExceptionWhenProvideIntItem()
//    {
//        $this->expectException(\TypeError::class);
//
//        new FloatCollection(1);
//    }

    public function testShouldThrowTypeErrorExceptionWhenProvideBoolItem()
    {
        $this->expectException(\TypeError::class);

        new FloatCollection(true);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideStringItem()
    {
        $this->expectException(\TypeError::class);

        new FloatCollection('item1');
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideArrayItem()
    {
        $this->expectException(\TypeError::class);

        new FloatCollection([]);
    }
}