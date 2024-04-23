<?php

namespace Goksagun\Collection\Test;

use Goksagun\Collection\Collection;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
#[UsesClass(Collection::class)]
final class CollectionTest extends TestCase
{
    public function testShouldInstantiate()
    {
        $this->assertInstanceOf(Collection::class, new Collection());
    }

    public function testShouldGetIterator()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertInstanceOf(\Traversable::class, $collection->getIterator());
    }

    public function testShouldIterateOverCollection()
    {
        $collection = new Collection('item1', 'item2');

        $items = [];
        foreach ($collection as $item) {
            $items[] = $item;
        }

        $this->assertEquals(['item1', 'item2'], $items);
    }

    public function testShouldCountItems()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertEquals(2, $collection->count());
    }

    public function testShouldCheckIfItemExists()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertTrue($collection->has(0));
        $this->assertFalse($collection->has(2));
    }

    public function testShouldGetAllItems()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertEquals(['item1', 'item2'], $collection->all());
    }

    public function testShouldGetItem()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertEquals('item1', $collection->get(0));
        $this->assertEquals('item2', $collection->get(1));
        $this->assertNull($collection->get(2));
    }

    public function testShouldGetItemWithIntIndex()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertEquals('item1', $collection->get(0));
        $this->assertEquals('item2', $collection->get(1));
        $this->assertNull($collection->get(2));
    }

    public function testShouldGetItemWithStringIndex()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertEquals('item1', $collection->get('0'));
        $this->assertEquals('item2', $collection->get('1'));
        $this->assertNull($collection->get('2'));
    }

    public function testShouldGetItemWithMixedIndex()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertEquals('item1', $collection->get(0));
        $this->assertEquals('item2', $collection->get('1'));
        $this->assertNull($collection->get(2));
    }

    public function testShouldGetFirstItem()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertEquals('item1', $collection->first());
    }

    public function testShouldGetFirstItemWithStringIndex()
    {
        $collection = new Collection(...['a' => 'item1', 'b' => 'item2']);

        $this->assertEquals('item1', $collection->first());
    }

    public function testShouldGetLastItem()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertEquals('item2', $collection->last());
    }

    public function testShouldGetLastItemWithStringIndex()
    {
        $collection = new Collection(...['a' => 'item1', 'b' => 'item2']);

        $this->assertEquals('item2', $collection->last());
    }

    public function testShouldCheckIfCollectionIsEmpty()
    {
        $collection = new Collection();

        $this->assertTrue($collection->isEmpty());
    }

    public function testShouldContainsItem()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertTrue($collection->contains('item1'));
        $this->assertFalse($collection->contains('item3'));
    }

    public function testShouldMapCollection()
    {
        $collection = new Collection('item1', 'item2');

        $items = $collection->map(function ($item) {
            return strtoupper($item);
        });

        $this->assertEquals(['ITEM1', 'ITEM2'], $items->all());
    }

    public function testShouldFilterCollection()
    {
        $collection = new Collection('item1', 'item2');

        $items = $collection->filter(function ($item) {
            return $item === 'item1';
        });

        $this->assertEquals(['item1'], $items->all());
    }

    public function testShouldReduceCollection()
    {
        $collection = new Collection(1, 2, 3);

        $sum = $collection->reduce(function ($carry, $item) {
            return $carry + $item;
        }, 0);

        $this->assertEquals(6, $sum);
    }

    public function testShouldSortCollection()
    {
        $collection = new Collection(3, 1, 2);

        $sorted = $collection->sort(function ($a, $b) {
            return $a <=> $b;
        });

        $this->assertEquals([1, 2, 3], $sorted->all());
    }

    public function testShouldSortCollectionWithKeys()
    {
        $collection = new Collection(...['c' => 3, 'a' => 1, 'b' => 2]);

        $sorted = $collection->sort(function ($a, $b) {
            return $a <=> $b;
        });

        $this->assertEquals(['a' => 1, 'b' => 2, 'c' => 3], $sorted->all());
    }

    public function testShouldMergeCollections()
    {
        $collection1 = new Collection('item1', 'item2');
        $collection2 = new Collection('item3', 'item4');
        $collection3 = new Collection('item5', 'item6');

        $merged = $collection1->merge($collection2)->merge($collection3);

        $this->assertEquals(['item1', 'item2', 'item3', 'item4', 'item5', 'item6'], $merged->all());
    }

    public function testShouldClearCollection()
    {
        $collection = new Collection('item1', 'item2');

        $collection->clear();

        $this->assertTrue($collection->isEmpty());
    }

    public function testShouldChunkCollection()
    {
        $collection = new Collection('item1', 'item2', 'item3');

        $chunks = $collection->chunk(2);

        $this->assertEquals(
            [['item1', 'item2'], ['item3']],
            \array_map(fn(Collection $chunk) => $chunk->all(), $chunks)
        );
    }

    public function testShouldGetCollectionKeys()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertEquals([0, 1], $collection->keys());
    }

    public function testShouldGetCollectionValues()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertEquals(['item1', 'item2'], $collection->values());
    }

    public function testShouldApplyCallbackToEachItemInCollection()
    {
        $collection = new Collection('item1', 'item2');

        $items = [];
        $collection->each(function ($item, $index) use (&$items) {
            $items[$index] = $item;
        });

        $this->assertEquals(['item1', 'item2'], $items);
    }

    public function testShouldExtractSpecifiedKeyFromEachItemInArrayCollection()
    {
        $collection = new Collection(
            ['name' => 'item1', 'price' => 100],
            ['name' => 'item2', 'price' => 200]
        );

        $items = $collection->pluck('name');

        $this->assertEquals(['item1', 'item2'], $items->all());
    }

    public function testShouldThrowExceptionWhenExtractingNonExistingProperty()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The item does not have the key "price".');
        $collection = new Collection(['name' => 'item1'], ['name' => 'item2']);

        $collection->pluck('price');
    }

    public function testShouldThrowExceptionWhenExtractingItemInNonArrayOrObjectCollection()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The item must be an array or an object.');
        $collection = new Collection('item1', 'item2');

        $collection->pluck('name');
    }
}
