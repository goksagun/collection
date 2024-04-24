<?php

namespace Goksagun\Collection;

/**
 * @implements Collection<array>
 */
class ArrayCollection extends Collection
{
    public function __construct(array ...$items)
    {
        parent::__construct(...$items);
    }
}