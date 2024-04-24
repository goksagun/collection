<?php

namespace Goksagun\Collection\Test\Fixtures;

use Goksagun\Collection\Collection;

/**
 * @implements Collection<CustomType>
 */
final class CustomTypeCollection extends Collection
{

    public function __construct(CustomType ...$items)
    {
        parent::__construct(...$items);
    }

}