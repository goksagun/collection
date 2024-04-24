<?php

namespace Goksagun\Collection\Test;

use Goksagun\Collection\Collection;
use Goksagun\Collection\Test\Fixtures\CustomType;
use Goksagun\Collection\Test\Fixtures\CustomTypeCollection;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
#[UsesClass(CustomTypeCollection::class)]
class CustomTypeCollectionTest extends TestCase
{

    public function testShouldInstantiateProductCollection()
    {
        $this->assertInstanceOf(CustomTypeCollection::class, new CustomTypeCollection());
    }

    public function testShouldGetAllProductsFromProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $this->assertEquals(2, $productCollection->count());
        $this->assertInstanceOf(Fixtures\CustomType::class, $productCollection->get(0));
        $this->assertEquals('CustomType 1', $productCollection->get(0)->getName());
        $this->assertEquals(100.99, $productCollection->get(0)->getPrice());
        $this->assertInstanceOf(Fixtures\CustomType::class, $productCollection->get(1));
        $this->assertEquals('CustomType 2', $productCollection->get(1)->getName());
        $this->assertEquals(200.99, $productCollection->get(1)->getPrice());
    }

    public function testShouldCheckIfProductExistsInProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $this->assertTrue($productCollection->has(0));
        $this->assertTrue($productCollection->has(1));
        $this->assertFalse($productCollection->has(2));
    }

    public function testShouldGetProductFromProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $this->assertInstanceOf(Fixtures\CustomType::class, $productCollection->get(0));
        $this->assertEquals('CustomType 1', $productCollection->get(0)->getName());
        $this->assertEquals(100.99, $productCollection->get(0)->getPrice());
        $this->assertInstanceOf(Fixtures\CustomType::class, $productCollection->get(1));
        $this->assertEquals('CustomType 2', $productCollection->get(1)->getName());
        $this->assertEquals(200.99, $productCollection->get(1)->getPrice());
        $this->assertNull($productCollection->get(2));
    }

    public function testShouldIterateOverProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $products = [];
        foreach ($productCollection as $product) {
            $products[] = $product;
        }

        $this->assertCount(2, $products);
        $this->assertInstanceOf(Fixtures\CustomType::class, $products[0]);
        $this->assertEquals('CustomType 1', $products[0]->getName());
        $this->assertEquals(100.99, $products[0]->getPrice());
        $this->assertInstanceOf(Fixtures\CustomType::class, $products[1]);
        $this->assertEquals('CustomType 2', $products[1]->getName());
        $this->assertEquals(200.99, $products[1]->getPrice());
    }

    public function testShouldGetProductCollectionItems()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $products = $productCollection->all();

        $this->assertCount(2, $products);
        $this->assertInstanceOf(Fixtures\CustomType::class, $products[0]);
        $this->assertEquals('CustomType 1', $products[0]->getName());
        $this->assertEquals(100.99, $products[0]->getPrice());
        $this->assertInstanceOf(Fixtures\CustomType::class, $products[1]);
        $this->assertEquals('CustomType 2', $products[1]->getName());
        $this->assertEquals(200.99, $products[1]->getPrice());
    }

    public function testShouldGetProductCollectionCount()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $this->assertEquals(2, $productCollection->count());
    }

    public function testShouldGetProductCollectionFirstItem()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $this->assertInstanceOf(Fixtures\CustomType::class, $productCollection->first());
        $this->assertEquals('CustomType 1', $productCollection->first()->getName());
        $this->assertEquals(100.99, $productCollection->first()->getPrice());
    }

    public function testShouldGetProductCollectionLastItem()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $this->assertInstanceOf(Fixtures\CustomType::class, $productCollection->last());
        $this->assertEquals('CustomType 2', $productCollection->last()->getName());
        $this->assertEquals(200.99, $productCollection->last()->getPrice());
    }

    public function testShouldCheckIfProductCollectionIsEmpty()
    {
        $productCollection = new CustomTypeCollection();

        $this->assertTrue($productCollection->isEmpty());
    }

    public function testShouldClearProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $productCollection->clear();

        $this->assertEquals(0, $productCollection->count());
    }

    public function testShouldChunkProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99),
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $chunks = $productCollection->chunk(2);

        $this->assertCount(2, $chunks);
        $this->assertInstanceOf(CustomTypeCollection::class, $chunks[0]);
        $this->assertInstanceOf(CustomTypeCollection::class, $chunks[1]);
        $this->assertEquals(2, $chunks[0]->count());
        $this->assertEquals(2, $chunks[1]->count());
        $this->assertInstanceOf(Fixtures\CustomType::class, $chunks[0]->get(0));
        $this->assertInstanceOf(Fixtures\CustomType::class, $chunks[0]->get(1));
        $this->assertInstanceOf(Fixtures\CustomType::class, $chunks[1]->get(0));
        $this->assertInstanceOf(Fixtures\CustomType::class, $chunks[1]->get(1));
        $this->assertEquals('CustomType 1', $chunks[0]->get(0)->getName());
        $this->assertEquals('CustomType 2', $chunks[0]->get(1)->getName());
        $this->assertEquals('CustomType 3', $chunks[1]->get(0)->getName());
        $this->assertEquals('CustomType 4', $chunks[1]->get(1)->getName());
        $this->assertEquals(100.99, $chunks[0]->get(0)->getPrice());
        $this->assertEquals(200.99, $chunks[0]->get(1)->getPrice());
        $this->assertEquals(300.99, $chunks[1]->get(0)->getPrice());
        $this->assertEquals(400.99, $chunks[1]->get(1)->getPrice());
    }

    public function testShouldReduceProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99),
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $total = $productCollection->reduce(function (float $total, Fixtures\CustomType $product) {
            return $total + $product->getPrice();
        }, 0);

        $this->assertEquals(1003.96, $total);
    }

    public function testShouldEachProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $productCollection->each(function (Fixtures\CustomType $product) {
            $product->setPrice($product->getPrice() + 10);
        });

        $this->assertEquals(110.99, $productCollection->get(0)->getPrice());
        $this->assertEquals(210.99, $productCollection->get(1)->getPrice());
    }

    public function testShouldEachProductCollectionReturnsItself()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $result = $productCollection->each(function (Fixtures\CustomType $product) {
            $product->setPrice($product->getPrice() + 10);
        });

        $this->assertInstanceOf(CustomTypeCollection::class, $result);
    }

    public function testShouldMapProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99),
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $mappedProductCollection = $productCollection->map(function (Fixtures\CustomType $product) {
            return new Fixtures\CustomType($product->getName(), $product->getPrice() + 10);
        });

        $this->assertEquals(110.99, $mappedProductCollection->get(0)->getPrice());
        $this->assertEquals(210.99, $mappedProductCollection->get(1)->getPrice());
        $this->assertEquals(310.99, $mappedProductCollection->get(2)->getPrice());
        $this->assertEquals(410.99, $mappedProductCollection->get(3)->getPrice());
    }

    public function testShouldMapProductCollectionReturnsItself()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99),
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $mappedProductCollection = $productCollection->map(function (Fixtures\CustomType $product) {
            return new Fixtures\CustomType($product->getName(), $product->getPrice() + 10);
        });

        $this->assertInstanceOf(CustomTypeCollection::class, $mappedProductCollection);
    }

    public function testShouldFilterProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99),
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $filteredProductCollection = $productCollection->filter(function (Fixtures\CustomType $product) {
            return $product->getPrice() > 300;
        });

        $this->assertEquals(2, $filteredProductCollection->count());
        $this->assertInstanceOf(Fixtures\CustomType::class, $filteredProductCollection->get(0));
        $this->assertEquals('CustomType 3', $filteredProductCollection->get(0)->getName());
        $this->assertEquals(300.99, $filteredProductCollection->get(0)->getPrice());
        $this->assertInstanceOf(Fixtures\CustomType::class, $filteredProductCollection->get(1));
        $this->assertEquals('CustomType 4', $filteredProductCollection->get(1)->getName());
        $this->assertEquals(400.99, $filteredProductCollection->get(1)->getPrice());
    }

    public function testShouldFilterProductCollectionReturnsItself()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99),
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $filteredProductCollection = $productCollection->filter(function (Fixtures\CustomType $product) {
            return $product->getPrice() > 300;
        });

        $this->assertInstanceOf(CustomTypeCollection::class, $filteredProductCollection);
    }

    public function testShouldSortProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $sortedProductCollection = $productCollection->sort(function (Fixtures\CustomType $a, Fixtures\CustomType $b) {
            return $a->getPrice() <=> $b->getPrice();
        });

        $this->assertEquals(100.99, $sortedProductCollection->get(0)->getPrice());
        $this->assertEquals(200.99, $sortedProductCollection->get(1)->getPrice());
        $this->assertEquals(300.99, $sortedProductCollection->get(2)->getPrice());
        $this->assertEquals(400.99, $sortedProductCollection->get(3)->getPrice());
    }

    public function testShouldSortProductCollectionWithKeys()
    {
        $productCollection = new CustomTypeCollection(...[
            'c' => new Fixtures\CustomType('CustomType 3', 300.99),
            'a' => new Fixtures\CustomType('CustomType 1', 100.99),
            'b' => new Fixtures\CustomType('CustomType 2', 200.99),
        ]);

        $sortedProductCollection = $productCollection->sort(function (Fixtures\CustomType $a, Fixtures\CustomType $b) {
            return $a->getPrice() <=> $b->getPrice();
        });

        $this->assertEquals(100.99, $sortedProductCollection->get('a')->getPrice());
        $this->assertEquals(200.99, $sortedProductCollection->get('b')->getPrice());
        $this->assertEquals(300.99, $sortedProductCollection->get('c')->getPrice());
    }

    public function testShouldSortProductCollectionContainsProductCollectionInstance()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $sortedProductCollection = $productCollection->sort(function (Fixtures\CustomType $a, Fixtures\CustomType $b) {
            return $a->getPrice() <=> $b->getPrice();
        });

        $this->assertInstanceOf(CustomTypeCollection::class, $sortedProductCollection);
    }

    public function testShouldSortProductCollectionContainsInstanceOfProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $sortedProductCollection = $productCollection->sort(function (Fixtures\CustomType $a, Fixtures\CustomType $b) {
            return $a->getPrice() <=> $b->getPrice();
        });

        $this->assertInstanceOf(CustomTypeCollection::class, $sortedProductCollection);
    }

    public function testShouldMergeTwoProductCollectionIntoOne()
    {
        $productCollection1 = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $productCollection2 = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $mergedProductCollection = $productCollection1->merge($productCollection2);

        $this->assertEquals(4, $mergedProductCollection->count());
        $this->assertInstanceOf(Fixtures\CustomType::class, $mergedProductCollection->get(0));
        $this->assertEquals('CustomType 1', $mergedProductCollection->get(0)->getName());
        $this->assertEquals(100.99, $mergedProductCollection->get(0)->getPrice());
        $this->assertInstanceOf(Fixtures\CustomType::class, $mergedProductCollection->get(1));
        $this->assertEquals('CustomType 2', $mergedProductCollection->get(1)->getName());
        $this->assertEquals(200.99, $mergedProductCollection->get(1)->getPrice());
        $this->assertInstanceOf(Fixtures\CustomType::class, $mergedProductCollection->get(2));
        $this->assertEquals('CustomType 3', $mergedProductCollection->get(2)->getName());
        $this->assertEquals(300.99, $mergedProductCollection->get(2)->getPrice());
        $this->assertInstanceOf(Fixtures\CustomType::class, $mergedProductCollection->get(3));
        $this->assertEquals('CustomType 4', $mergedProductCollection->get(3)->getName());
        $this->assertEquals(400.99, $mergedProductCollection->get(3)->getPrice());
    }

    public function testShouldMergeProductCollectionReturnsProductCollection()
    {
        $productCollection1 = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99)
        );

        $productCollection2 = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $mergedProductCollection = $productCollection1->merge($productCollection2);

        $this->assertInstanceOf(CustomTypeCollection::class, $mergedProductCollection);
    }

    public function testShouldPluckProductCollection()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99),
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $prices = $productCollection->pluck('price');

        $this->assertEquals([100.99, 200.99, 300.99, 400.99], $prices->all());
    }

    public function testShouldPluckReturnCollectionInstance()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99),
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 4', 400.99)
        );

        $prices = $productCollection->pluck('price');

        $this->assertInstanceOf(Collection::class, $prices);
    }

    public function testShouldPluckProductCollectionWithKeys()
    {
        $productCollection = new CustomTypeCollection(...[
            'a' => new Fixtures\CustomType('CustomType 1', 100.99),
            'b' => new Fixtures\CustomType('CustomType 2', 200.99),
            'c' => new Fixtures\CustomType('CustomType 3', 300.99),
            'd' => new Fixtures\CustomType('CustomType 4', 400.99),
        ]);

        $prices = $productCollection->pluck('price');

        $this->assertEquals(['a' => 100.99, 'b' => 200.99, 'c' => 300.99, 'd' => 400.99], $prices->all());
    }

    public function testShouldPluckProductCollectionWithKeysAndValues()
    {
        $productCollection = new CustomTypeCollection(
            new Fixtures\CustomType('CustomType 1', 100.99),
            new Fixtures\CustomType('CustomType 2', 200.99),
            new Fixtures\CustomType('CustomType 3', 300.99),
            new Fixtures\CustomType('CustomType 4', 400.99),
        );

        $prices = $productCollection->pluck('price', 'name');

        $this->assertEquals(
            [['CustomType 1' => 100.99], ['CustomType 2' => 200.99], ['CustomType 3' => 300.99], ['CustomType 4' => 400.99]],
            $prices->all()
        );
    }

    public function testShouldPluckThrowExceptionWhenExtractingNonExistingPropertyInProductCollection()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The item does not have the property "stock".');
        $collection = new CustomTypeCollection(
            new CustomType('item1', 100),
            new CustomType('item2', 200)
        );

        $collection->pluck('stock');
    }

}