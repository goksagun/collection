<?php declare(strict_types=1);

namespace Goksagun\Collection\Test;

use Goksagun\Collection\ArrayCollection;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
#[UsesClass(ArrayCollection::class)]
class ArrayCollectionTest extends TestCase
{
    public function testShouldInstantiate()
    {
        $this->assertInstanceOf(ArrayCollection::class, new ArrayCollection());
    }

    public function testShouldSuccessWhenProvideArrayItem()
    {
        $arrayCollection = new ArrayCollection([]);

        $this->assertContainsOnly('array', $arrayCollection->all());
    }

    public function testShouldSuccessWhenProvideMultipleArrayItems()
    {
        $arrayCollection = new ArrayCollection([], [], []);

        $this->assertContainsOnly('array', $arrayCollection->all());
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideIntItem()
    {
        $this->expectException(\TypeError::class);

        new ArrayCollection(1);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideFloatItem()
    {
        $this->expectException(\TypeError::class);

        new ArrayCollection(1.1);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideBoolItem()
    {
        $this->expectException(\TypeError::class);

        new ArrayCollection(true);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideStringItem()
    {
        $this->expectException(\TypeError::class);

        new ArrayCollection('item1');
    }
}