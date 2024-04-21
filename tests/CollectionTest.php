<?php

namespace App\Test;

use Goksagun\Collection\Collection;
use Goksagun\Collection\Test\Fixtures\Product;
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

    public function testShouldCreateStaticCall()
    {
        $this->assertInstanceOf(Collection::class, Collection::make());
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

    public function testShouldAddItem()
    {
        $collection = new Collection();
        $collection->add('item');

        $this->assertEquals(1, $collection->count());
    }

    public function testShouldAddItemWithIndex()
    {
        $collection = new Collection();
        $collection->add('item', 'index');

        $this->assertEquals(1, $collection->count());
        $this->assertEquals('item', $collection->get('index'));
    }

    public function testShouldThrowExceptionWhenAddingExistingItem()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The index 0 already exists in the collection.');

        $collection = new Collection();
        $collection->add('item1', 0);
        $collection->add('item2', 0);
    }


    public function testShouldCountItems()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertEquals(2, $collection->count());
    }

    public function testShouldCheckIfItemExists()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertTrue($collection->exists(0));
        $this->assertFalse($collection->exists(2));
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

        $collection->add('item');

        $this->assertFalse($collection->isEmpty());
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

    public function testShouldRemoveItem()
    {
        $collection = new Collection('item1', 'item2');

        $collection->remove(0);

        $this->assertEquals([1 => 'item2'], $collection->all());
    }

    public function testShouldThrowExceptionWhenRemovingNonExistingItem()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The index 2 does not exist in the collection.');

        $collection = new Collection('item1', 'item2');
        $collection->remove(2);
    }

    public function testShouldClearCollection()
    {
        $collection = new Collection('item1', 'item2');

        $collection->clear();

        $this->assertTrue($collection->isEmpty());
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

    public function testShouldExtractSpecifiedPropertyFromEachItemInObjectCollection()
    {
        $collection = new Collection(
            new Product('item1', 100),
            new Product('item2', 200)
        );

        $items = $collection->pluck('name');

        $this->assertEquals(['item1', 'item2'], $items->all());
    }

    public function testShouldExtractSpecifiedPropertyAndKeyFromEachItemInObjectCollection()
    {
        $collection = new Collection(
            new Product('item1', 100),
            new Product('item2', 200)
        );

        $items = $collection->pluck('price', 'name');

        $this->assertEquals([['item1' => 100], ['item2' => 200]], $items->all());
    }

    public function testShouldThrowExceptionWhenExtractingItemInNonArrayOrObjectCollection()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The item must be an array or an object.');
        $collection = new Collection('item1', 'item2');

        $collection->pluck('name');
    }
}
