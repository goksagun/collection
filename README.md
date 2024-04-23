# Collection

A PHP collection library providing functionalities for managing and manipulating product collections.

## Features

- Create a collection of items
- Add a item to the collection
- Map over the collection to apply a function to each item
- Filter the collection based on a predicate
- Pluck a specific property from each item in the collection
- Reduce the collection to a single value
- Sort the collection based on a custom comparison function

## Installation

Use [Composer](https://getcomposer.org/) to install this library:

```bash
composer require goksagun/collection
```

## Usage

Here's a basic example of how to use this library:

```php
<?php

namespace Acme;

class Product
{
    public function __construct (
        private string $name,
        private float $price
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

}
```

```php
<?php

namespace Acme;

use Acme\Product;
use Goksagun\Collection\Collection;

/**
 * @implements Collection<Product>
 */
final class ProductCollection extends Collection
{

    public function __construct(Product ...$items)
    {
        parent::__construct(...$items);
    }

}
```

```php
<?php

namespace Acme;

use Acme\Product;
use Acme\ProductCollection;

$collection = new ProductCollection(
    new Product('Product 1', 100.99),
    new Product('Product 2', 200.99),
    new Product('Product 3', 300.99),
);

$total = $collection
    ->add(new Product('Product 4', 400.99))
    ->map(function (Product $product) {
        return new Product($product->getName(), $product->getPrice() * 1.18);
    })
    ->each(function (\Goksagun\Collection\Test\Fixtures\Product $product, int $index) {
        echo "Product {$index}: {$product->getName()} - {$product->getPrice()}\n";
    })
    ->filter(function (Product $product) {
        return $product->getPrice() > 300;
    })
    ->pluck('price')
    ->reduce(function (float $total, float $price) {
        return $total + $price;
    }, 0);

echo "Total: {$total}\n";

// Product 0: Product 1 - 119.1682
// Product 1: Product 2 - 237.1682
// Product 2: Product 3 - 355.1682
// Product 3: Product 4 - 473.1682
// Product 0: Product 3 - 355.1682
// Product 1: Product 4 - 473.1682
// Total: 828.3364

```

## Testing

Run the tests with:

```bash
composer test
```

## License

This project is licensed under the MIT License - see the LICENSE file for details.