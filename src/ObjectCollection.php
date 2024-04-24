<?php

namespace Goksagun\Collection;

/**
 * @implements Collection<object>
 */
class ObjectCollection extends Collection
{
    public function __construct(object ...$items)
    {
        parent::__construct(...$items);
    }
}