<?php

namespace App;

class Collection
{
    protected array $items;

    public function __construct(object ...$items) {
        $this->items = $items;
    }

    public function add(mixed $item): void
    {
        $this->items[] = $item;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function exists(int|string $index): bool {
        return array_key_exists($index, $this->items);
    }

    public function all(): array {
        return $this->items;
    }

    public function get(int|string $index): ?object {
        if (!$this->exists($index)) {
            return null;
        }

        return $this->items[$index];
    }
}
