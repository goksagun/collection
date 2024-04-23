<?php

namespace Goksagun\Collection\Test\Fixtures;

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