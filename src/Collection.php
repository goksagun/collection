<?php

namespace Goksagun\Collection;

/**
 * @template T
 */
class Collection implements \IteratorAggregate, \Countable
{
    /**
     * @var array<T>
     */
    protected array $items;

    /**
     * @param T ...$items
     */
    public function __construct(...$items)
    {
        $this->items = $items;
    }

    public static function make(...$items): self
    {
        return new self(...$items);
    }

    /**
     * @return \Traversable<T>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * Add an item to the collection. Optionally, provide an index.
     *
     * @param T $item
     * @return self<T>
     */
    public function add(mixed $item, int|string $index = null): self
    {
        if (null !== $index) {
            if ($this->exists($index)) {
                throw new \RuntimeException(\sprintf('The index %s already exists in the collection.', $index));
            }

            $this->items[$index] = $item;

            return $this;
        }

        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove an item from the collection by index.
     *
     * @return self<T>
     */
    public function remove(int|string $index): self
    {
        if (!$this->exists($index)) {
            throw new \RuntimeException(\sprintf('The index %s does not exist in the collection.', $index));
        }

        unset($this->items[$index]);

        return $this;
    }

    /**
     * Get all items from the collection.
     *
     * @return array<T>
     */
    public function all(): array
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
     * Check if a specific item is in the collection.
     *
     * @param T $item
     */
    public function contains($item): bool
    {
        return \in_array($item, $this->items, true);
    }

    /**
     * Calculate the number of items in the collection.
     */
    public function count(): int
    {
        return \count($this->items);
    }

    /**
     * Get the first item from the collection.
     *
     * @return T|null
     */
    public function first(): mixed
    {
        return $this->get(\array_key_first($this->items));
    }

    /**
     * Get the last item from the collection.
     *
     * @return T|null
     */
    public function last(): mixed
    {
        return $this->get(\array_key_last($this->items));
    }

    /**
     * Get the keys of the collection.
     */
    public function keys(): array
    {
        return \array_keys($this->items);
    }

    /**
     * Get the values of the collection.
     */
    public function values(): array
    {
        return \array_values($this->items);
    }

    /**
     * Check if the collection is empty.
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * Clear all items from the collection.
     *
     * @return self<T>
     */
    public function clear(): self
    {
        $this->items = [];

        return $this;
    }

    /**
     * Reduce the collection to a single value using a callback function.
     *
     * @param callable(T, T):T $callback
     * @param mixed|null $initial
     */
    public function reduce(callable $callback, mixed $initial = null): mixed
    {
        return \array_reduce($this->items, $callback, $initial);
    }

    /**
     * Apply a callback function to all items in the collection.
     *
     * @param callable(T):void $callback
     * @return self<T>
     */
    public function each(callable $callback): self
    {
        \array_walk($this->items, $callback);

        return $this;
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
     * Get a subset of the collection from an array or object given a key or property.
     *
     * @return self<T>
     */
    public function pluck(int|string $key, int|string $indexKey = null): self
    {
        return new self(...\array_map(function (mixed $item) use ($key, $indexKey) {
            if (\is_array($item)) {
                if (null !== $indexKey) {
                    return [$item[$indexKey] => $item[$key]];
                }

                return $item[$key];
            }

            if (\is_object($item)) {
                $reflector = new \ReflectionObject($item);

                if (null !== $indexKey) {
                    return [
                        $reflector->getProperty($indexKey)->getValue($item) => $reflector->getProperty(
                            $key
                        )->getValue($item)
                    ];
                }

                return $reflector->getProperty($key)->getValue($item);
            }

            throw new \RuntimeException('The item must be an array or an object.');
        }, $this->items));
    }
}
