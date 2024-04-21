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

}
