<?php

namespace Goksagun\Collection\Test;

use Goksagun\Collection\Collection;
use Goksagun\Collection\Test\Fixtures\Product;
use Goksagun\Collection\Test\Fixtures\ProductCollection;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
#[UsesClass(ProductCollection::class)]
class ProductCollectionTest extends TestCase
{

    public function testShouldInstantiateProductCollection()
    {
        $this->assertInstanceOf(ProductCollection::class, new ProductCollection());
    }

    public function testShouldGetAllProductsFromProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $this->assertEquals(2, $productCollection->count());
        $this->assertInstanceOf(Fixtures\Product::class, $productCollection->get(0));
        $this->assertEquals('Product 1', $productCollection->get(0)->getName());
        $this->assertEquals(100.99, $productCollection->get(0)->getPrice());
        $this->assertInstanceOf(Fixtures\Product::class, $productCollection->get(1));
        $this->assertEquals('Product 2', $productCollection->get(1)->getName());
        $this->assertEquals(200.99, $productCollection->get(1)->getPrice());
    }

    public function testShouldCheckIfProductExistsInProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $this->assertTrue($productCollection->has(0));
        $this->assertTrue($productCollection->has(1));
        $this->assertFalse($productCollection->has(2));
    }

    public function testShouldGetProductFromProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $this->assertInstanceOf(Fixtures\Product::class, $productCollection->get(0));
        $this->assertEquals('Product 1', $productCollection->get(0)->getName());
        $this->assertEquals(100.99, $productCollection->get(0)->getPrice());
        $this->assertInstanceOf(Fixtures\Product::class, $productCollection->get(1));
        $this->assertEquals('Product 2', $productCollection->get(1)->getName());
        $this->assertEquals(200.99, $productCollection->get(1)->getPrice());
        $this->assertNull($productCollection->get(2));
    }

    public function testShouldIterateOverProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $products = [];
        foreach ($productCollection as $product) {
            $products[] = $product;
        }

        $this->assertCount(2, $products);
        $this->assertInstanceOf(Fixtures\Product::class, $products[0]);
        $this->assertEquals('Product 1', $products[0]->getName());
        $this->assertEquals(100.99, $products[0]->getPrice());
        $this->assertInstanceOf(Fixtures\Product::class, $products[1]);
        $this->assertEquals('Product 2', $products[1]->getName());
        $this->assertEquals(200.99, $products[1]->getPrice());
    }

    public function testShouldGetProductCollectionItems()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $products = $productCollection->all();

        $this->assertCount(2, $products);
        $this->assertInstanceOf(Fixtures\Product::class, $products[0]);
        $this->assertEquals('Product 1', $products[0]->getName());
        $this->assertEquals(100.99, $products[0]->getPrice());
        $this->assertInstanceOf(Fixtures\Product::class, $products[1]);
        $this->assertEquals('Product 2', $products[1]->getName());
        $this->assertEquals(200.99, $products[1]->getPrice());
    }

    public function testShouldGetProductCollectionCount()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $this->assertEquals(2, $productCollection->count());
    }

    public function testShouldGetProductCollectionFirstItem()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $this->assertInstanceOf(Fixtures\Product::class, $productCollection->first());
        $this->assertEquals('Product 1', $productCollection->first()->getName());
        $this->assertEquals(100.99, $productCollection->first()->getPrice());
    }

    public function testShouldGetProductCollectionLastItem()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $this->assertInstanceOf(Fixtures\Product::class, $productCollection->last());
        $this->assertEquals('Product 2', $productCollection->last()->getName());
        $this->assertEquals(200.99, $productCollection->last()->getPrice());
    }

    public function testShouldCheckIfProductCollectionIsEmpty()
    {
        $productCollection = new ProductCollection();

        $this->assertTrue($productCollection->isEmpty());
    }

    public function testShouldClearProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $productCollection->clear();

        $this->assertEquals(0, $productCollection->count());
    }

    public function testShouldChunkProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99),
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $chunks = $productCollection->chunk(2);

        $this->assertCount(2, $chunks);
        $this->assertInstanceOf(ProductCollection::class, $chunks[0]);
        $this->assertInstanceOf(ProductCollection::class, $chunks[1]);
        $this->assertEquals(2, $chunks[0]->count());
        $this->assertEquals(2, $chunks[1]->count());
        $this->assertInstanceOf(Fixtures\Product::class, $chunks[0]->get(0));
        $this->assertInstanceOf(Fixtures\Product::class, $chunks[0]->get(1));
        $this->assertInstanceOf(Fixtures\Product::class, $chunks[1]->get(0));
        $this->assertInstanceOf(Fixtures\Product::class, $chunks[1]->get(1));
        $this->assertEquals('Product 1', $chunks[0]->get(0)->getName());
        $this->assertEquals('Product 2', $chunks[0]->get(1)->getName());
        $this->assertEquals('Product 3', $chunks[1]->get(0)->getName());
        $this->assertEquals('Product 4', $chunks[1]->get(1)->getName());
        $this->assertEquals(100.99, $chunks[0]->get(0)->getPrice());
        $this->assertEquals(200.99, $chunks[0]->get(1)->getPrice());
        $this->assertEquals(300.99, $chunks[1]->get(0)->getPrice());
        $this->assertEquals(400.99, $chunks[1]->get(1)->getPrice());
    }

    public function testShouldReduceProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99),
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $total = $productCollection->reduce(function (float $total, Fixtures\Product $product) {
            return $total + $product->getPrice();
        }, 0);

        $this->assertEquals(1003.96, $total);
    }

    public function testShouldEachProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $productCollection->each(function (Fixtures\Product $product) {
            $product->setPrice($product->getPrice() + 10);
        });

        $this->assertEquals(110.99, $productCollection->get(0)->getPrice());
        $this->assertEquals(210.99, $productCollection->get(1)->getPrice());
    }

    public function testShouldEachProductCollectionReturnsItself()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $result = $productCollection->each(function (Fixtures\Product $product) {
            $product->setPrice($product->getPrice() + 10);
        });

        $this->assertInstanceOf(ProductCollection::class, $result);
    }

    public function testShouldMapProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99),
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $mappedProductCollection = $productCollection->map(function (Fixtures\Product $product) {
            return new Fixtures\Product($product->getName(), $product->getPrice() + 10);
        });

        $this->assertEquals(110.99, $mappedProductCollection->get(0)->getPrice());
        $this->assertEquals(210.99, $mappedProductCollection->get(1)->getPrice());
        $this->assertEquals(310.99, $mappedProductCollection->get(2)->getPrice());
        $this->assertEquals(410.99, $mappedProductCollection->get(3)->getPrice());
    }

    public function testShouldMapProductCollectionReturnsItself()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99),
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $mappedProductCollection = $productCollection->map(function (Fixtures\Product $product) {
            return new Fixtures\Product($product->getName(), $product->getPrice() + 10);
        });

        $this->assertInstanceOf(ProductCollection::class, $mappedProductCollection);
    }

    public function testShouldFilterProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99),
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $filteredProductCollection = $productCollection->filter(function (Fixtures\Product $product) {
            return $product->getPrice() > 300;
        });

        $this->assertEquals(2, $filteredProductCollection->count());
        $this->assertInstanceOf(Fixtures\Product::class, $filteredProductCollection->get(0));
        $this->assertEquals('Product 3', $filteredProductCollection->get(0)->getName());
        $this->assertEquals(300.99, $filteredProductCollection->get(0)->getPrice());
        $this->assertInstanceOf(Fixtures\Product::class, $filteredProductCollection->get(1));
        $this->assertEquals('Product 4', $filteredProductCollection->get(1)->getName());
        $this->assertEquals(400.99, $filteredProductCollection->get(1)->getPrice());
    }

    public function testShouldFilterProductCollectionReturnsItself()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99),
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $filteredProductCollection = $productCollection->filter(function (Fixtures\Product $product) {
            return $product->getPrice() > 300;
        });

        $this->assertInstanceOf(ProductCollection::class, $filteredProductCollection);
    }

    public function testShouldSortProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $sortedProductCollection = $productCollection->sort(function (Fixtures\Product $a, Fixtures\Product $b) {
            return $a->getPrice() <=> $b->getPrice();
        });

        $this->assertEquals(100.99, $sortedProductCollection->get(0)->getPrice());
        $this->assertEquals(200.99, $sortedProductCollection->get(1)->getPrice());
        $this->assertEquals(300.99, $sortedProductCollection->get(2)->getPrice());
        $this->assertEquals(400.99, $sortedProductCollection->get(3)->getPrice());
    }

    public function testShouldSortProductCollectionWithKeys()
    {
        $productCollection = new ProductCollection(...[
            'c' => new Fixtures\Product('Product 3', 300.99),
            'a' => new Fixtures\Product('Product 1', 100.99),
            'b' => new Fixtures\Product('Product 2', 200.99),
        ]);

        $sortedProductCollection = $productCollection->sort(function (Fixtures\Product $a, Fixtures\Product $b) {
            return $a->getPrice() <=> $b->getPrice();
        });

        $this->assertEquals(100.99, $sortedProductCollection->get('a')->getPrice());
        $this->assertEquals(200.99, $sortedProductCollection->get('b')->getPrice());
        $this->assertEquals(300.99, $sortedProductCollection->get('c')->getPrice());
    }

    public function testShouldSortProductCollectionContainsProductCollectionInstance()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $sortedProductCollection = $productCollection->sort(function (Fixtures\Product $a, Fixtures\Product $b) {
            return $a->getPrice() <=> $b->getPrice();
        });

        $this->assertInstanceOf(ProductCollection::class, $sortedProductCollection);
    }

    public function testShouldSortProductCollectionContainsInstanceOfProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $sortedProductCollection = $productCollection->sort(function (Fixtures\Product $a, Fixtures\Product $b) {
            return $a->getPrice() <=> $b->getPrice();
        });

        $this->assertInstanceOf(ProductCollection::class, $sortedProductCollection);
    }

    public function testShouldMergeTwoProductCollectionIntoOne()
    {
        $productCollection1 = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $productCollection2 = new ProductCollection(
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $mergedProductCollection = $productCollection1->merge($productCollection2);

        $this->assertEquals(4, $mergedProductCollection->count());
        $this->assertInstanceOf(Fixtures\Product::class, $mergedProductCollection->get(0));
        $this->assertEquals('Product 1', $mergedProductCollection->get(0)->getName());
        $this->assertEquals(100.99, $mergedProductCollection->get(0)->getPrice());
        $this->assertInstanceOf(Fixtures\Product::class, $mergedProductCollection->get(1));
        $this->assertEquals('Product 2', $mergedProductCollection->get(1)->getName());
        $this->assertEquals(200.99, $mergedProductCollection->get(1)->getPrice());
        $this->assertInstanceOf(Fixtures\Product::class, $mergedProductCollection->get(2));
        $this->assertEquals('Product 3', $mergedProductCollection->get(2)->getName());
        $this->assertEquals(300.99, $mergedProductCollection->get(2)->getPrice());
        $this->assertInstanceOf(Fixtures\Product::class, $mergedProductCollection->get(3));
        $this->assertEquals('Product 4', $mergedProductCollection->get(3)->getName());
        $this->assertEquals(400.99, $mergedProductCollection->get(3)->getPrice());
    }

    public function testShouldMergeProductCollectionReturnsProductCollection()
    {
        $productCollection1 = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99)
        );

        $productCollection2 = new ProductCollection(
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $mergedProductCollection = $productCollection1->merge($productCollection2);

        $this->assertInstanceOf(ProductCollection::class, $mergedProductCollection);
    }

    public function testShouldPluckProductCollection()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99),
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $prices = $productCollection->pluck('price');

        $this->assertEquals([100.99, 200.99, 300.99, 400.99], $prices->all());
    }

    public function testShouldPluckReturnCollectionInstance()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99),
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 4', 400.99)
        );

        $prices = $productCollection->pluck('price');

        $this->assertInstanceOf(Collection::class, $prices);
    }

    public function testShouldPluckProductCollectionWithKeys()
    {
        $productCollection = new ProductCollection(...[
            'a' => new Fixtures\Product('Product 1', 100.99),
            'b' => new Fixtures\Product('Product 2', 200.99),
            'c' => new Fixtures\Product('Product 3', 300.99),
            'd' => new Fixtures\Product('Product 4', 400.99),
        ]);

        $prices = $productCollection->pluck('price');

        $this->assertEquals(['a' => 100.99, 'b' => 200.99, 'c' => 300.99, 'd' => 400.99], $prices->all());
    }

    public function testShouldPluckProductCollectionWithKeysAndValues()
    {
        $productCollection = new ProductCollection(
            new Fixtures\Product('Product 1', 100.99),
            new Fixtures\Product('Product 2', 200.99),
            new Fixtures\Product('Product 3', 300.99),
            new Fixtures\Product('Product 4', 400.99),
        );

        $prices = $productCollection->pluck('price', 'name');

        $this->assertEquals(
            [['Product 1' => 100.99], ['Product 2' => 200.99], ['Product 3' => 300.99], ['Product 4' => 400.99]],
            $prices->all()
        );
    }

    public function testShouldPluckThrowExceptionWhenExtractingNonExistingPropertyInProductCollection()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The item does not have the property "stock".');
        $collection = new ProductCollection(
            new Product('item1', 100),
            new Product('item2', 200)
        );

        $collection->pluck('stock');
    }

}