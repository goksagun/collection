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
     * Add an item to the collection. Optionally, provide an index.
     *
     * @param T $item
     */
    public function add(mixed $item, int|string|null $index = null): void
    {
        if (null !== $index) {
            if ($this->exists($index)) {
                throw new \RuntimeException(\sprintf('The index %s already exists in the collection.', $index));
            }

            $this->items[$index] = $item;

            return;
        }

        $this->items[] = $item;
    }

    /**
     * Calculate the number of items in the collection.
     */
    public function count(): int
    {
        return \count($this->items);
    }

    /**
     * Get all items from the collection.
     *
     * @return array<T>
     */
    public function all(): iterable
    {
        return $this->items;
    }

    /**
     * Get an item from the collection by index.
     *
     * @return T|null
     */
    public function get(int|string $index): mixed
    {
        if (!$this->exists($index)) {
            return null;
        }

        return $this->items[$index];
    }

    /**
     * Check if an item exists in the collection by index.
     */
    public function exists(int|string $index): bool
    {
        return \array_key_exists($index, $this->items);
    }

    /**
     * Get the first item from the collection.
     *
     * @return T|null
     */
    public function first(): mixed
    {
        return $this->get(0);
    }

    /**
     * Get the last item from the collection.
     *
     * @return T|null
     */
    public function last(): mixed
    {
        return $this->get($this->count() - 1);
    }

    /**
     * Check if the collection is empty.
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * Check if a specific item is in the collection.
     *
     * @param T $item
     */
    public function contains($item): bool
    {
        return \in_array($item, $this->items, true);
    }

    /**
     * Apply a callback function to all items in the collection.
     *
     * @param callable(T):T $callback
     * @return self<T>
     */
    public function map(callable $callback): self
    {
        $items = \array_map($callback, $this->items);

        return new self(...$items);
    }

    /**
     * Filter the collection using a callback function.
     *
     * @param callable(T):bool $callback
     * @return self<T>
     */
    public function filter(callable $callback): self
    {
        $items = \array_filter($this->items, $callback);

        return new self(...$items);
    }

    /**
     * Reduce the collection to a single value using a callback function.
     *
     * @param callable(T, T):T $callback
     * @param mixed|null $initial
     * @return T
     */
    public function reduce(callable $callback, mixed $initial = null)
    {
        return \array_reduce($this->items, $callback, $initial);
    }

    /**
     * Sort the collection using a callback function.
     *
     * @param callable(T, T):int $callback
     * @return self<T>
     */
    public function sort(callable $callback): self
    {
        $items = $this->items;
        \uasort($items, $callback);

        return new self(...$items);
    }

    /**
     * Merge the collection with another collection.
     *
     * @param self<T> $collection
     * @return self<T>
     */
    public function merge(Collection $collection): self
    {
        return new self(...\array_merge($this->items, $collection->all()));
    }

    /**
     * Clear all items from the collection.
     */
    public function clear(): void
    {
        $this->items = [];
    }
}
