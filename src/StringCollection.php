<?php

namespace Goksagun\Collection;

/**
 * @implements Collection<string>
 */
class StringCollection extends Collection
{
    public function __construct(string ...$items)
    {
        parent::__construct(...$items);
    }
}