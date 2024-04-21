<?php

namespace App;

use Traversable;

/**
 * @template T
 */
class Collection implements \IteratorAggregate, \Countable
{
    /**
     * @var iterable<T>
     */
    protected iterable $items;

    /**
     * @param T ...$items
     */
    public function __construct(...$items)
    {
        $this->items = $items;
    }

    /**
     * @return Traversable<T>
     */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * @param T $item
     */
    public function add($item): void
    {
        $this->items[] = $item;
    }

    public function count(): int
    {
        return \count($this->items);
    }

    /**
     * @return array<T>
     */
    public function all(): iterable
    {
        return $this->items;
    }

    /**
     * @return T|null
     */
    public function get(int|string $index): mixed
    {
        if (!$this->exists($index)) {
            return null;
        }

        return $this->items[$index];
    }

    public function exists(int|string $index): bool
    {
        return \array_key_exists($index, $this->items);
    }
}
