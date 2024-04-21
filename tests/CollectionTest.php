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

    public function testShouldGetIterator()
    {
        $collection = new Collection('item1', 'item2');

        $this->assertInstanceOf(\Traversable::class, $collection->getIterator());
    }

}
