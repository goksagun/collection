<?php

namespace Goksagun\Collection;

/**
 * @implements Collection<float>
 */
class FloatCollection extends Collection
{
    public function __construct(float ...$items)
    {
        parent::__construct(...$items);
    }
}