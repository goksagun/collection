<?php declare(strict_types=1);

namespace Goksagun\Collection;

/**
 * @implements Collection<int>
 */
class IntCollection extends Collection
{
    public function __construct(int ...$items)
    {
        parent::__construct(...$items);
    }
}