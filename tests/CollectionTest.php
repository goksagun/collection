<?php

namespace App\Test;

use App\Collection;
use PHPUnit\Framework\TestCase;

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

    public function testShouldAddItem()
    {
        $collection = new Collection();
        $collection->add('item');

        $this->assertEquals(1, $collection->count());
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

    public function testShouldGetLastItem()
    {
        $collection = new Collection('item1', 'item2');

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

    public function testShouldClearCollection()
    {
        $collection = new Collection('item1', 'item2');

        $collection->clear();

        $this->assertTrue($collection->isEmpty());
    }
}