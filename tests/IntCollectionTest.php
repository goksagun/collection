<?php declare(strict_types=1);

namespace Goksagun\Collection\Test;

use Goksagun\Collection\IntCollection;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
#[UsesClass(IntCollection::class)]
class IntCollectionTest extends TestCase
{
    public function testShouldInstantiate()
    {
        $this->assertInstanceOf(IntCollection::class, new IntCollection());
    }

    public function testShouldSuccessWhenProvideIntItem()
    {
        $intCollection = new IntCollection(1);

        $this->assertContainsOnly('int', $intCollection->all());
    }

    public function testShouldSuccessWhenProvideMultipleIntItems()
    {
        $intCollection = new IntCollection(1, 2, 3);

        $this->assertContainsOnly('int', $intCollection->all());
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideFloatItem()
    {
        $this->expectException(\TypeError::class);

        new IntCollection(1.1);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideBoolItem()
    {
        $this->expectException(\TypeError::class);

        new IntCollection(true);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideStringItem()
    {
        $this->expectException(\TypeError::class);

        new IntCollection('item1');
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideArrayItem()
    {
        $this->expectException(\TypeError::class);

        new IntCollection([]);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideObjectItem()
    {
        $this->expectException(\TypeError::class);

        new IntCollection(new \stdClass());
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideNullItem()
    {
        $this->expectException(\TypeError::class);

        new IntCollection(null);
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideResourceItem()
    {
        $this->expectException(\TypeError::class);

        new IntCollection(fopen('php://memory', 'r'));
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideCallableItem()
    {
        $this->expectException(\TypeError::class);

        new IntCollection(fn() => 'item1');
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideIterableItem()
    {
        $this->expectException(\TypeError::class);

        new IntCollection(new \ArrayIterator());
    }

    public function testShouldThrowTypeErrorExceptionWhenProvideObjectItemWithToString()
    {
        $this->expectException(\TypeError::class);

        new IntCollection(new class {
            public function __toString()
            {
                return 'item1';
            }
        });
    }
}