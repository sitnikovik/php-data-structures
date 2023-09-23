<?php

namespace Sitnikovik\DataStructures;

use InvalidArgumentException;
use OverflowException;
use UnderflowException;

/**
 * Queue implementation
 */
class Queue
{
    /**
     * Current queue size
     *
     * @var int
     */
    protected $size;

    /**
     * Head index
     *
     * @var int
     */
    protected $head;

    /**
     * Tail index
     *
     * @var int
     */
    protected $tail;

    /**
     * Max queue capacity
     *
     * @var int
     */
    protected $capacity;

    /**
     * Queue items
     *
     * @var array
     */
    protected $items;

    /**
     * @param int $capacity Max queue capacity
     * @param array $items Initial queue items
     */
    public function __construct(int $capacity, array $items = [])
    {
        if ($capacity < 1) {
            throw new InvalidArgumentException('Capacity must be greater than 0');
        }
        $size = count($items);
        if (!empty($items) && $size > $capacity) {
            throw new OverflowException('Items size is bigger than queue capacity');
        }

        $this->size = count($items);
        $this->tail = $this->size;
        $this->head = 0;
        $this->capacity = $capacity;
        $this->items = $items;
    }

    /**
     * Adds item to queue end
     *
     * @param mixed $item
     * @return void
     */
    public function push($item): void
    {
        if ($this->size === $this->capacity) {
            throw new OverflowException('Queue is full');
        }

        $this->items[] = $item;
        $this->tail++;
        $this->size++;
    }

    /**
     * Returns item and removes it from queue
     *
     * @return mixed
     */
    public function pop()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Queue is empty');
        }

        $item = $this->items[$this->head];
        unset($this->items[$this->head]);
        $this->head++;
        $this->size--;

        return $item;
    }

    /**
     * Returns item from queue end but not removes it
     *
     * @return mixed
     */
    public function peek()
    {
        if ($this->isEmpty()) {
            throw new UnderflowException('Queue is empty');
        }

        return $this->items[$this->head];
    }

    /**
     * Checks if queue is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->size === 0;
    }

    /**
     * Checks if queue is full
     *
     * @return bool
     */
    public function isFull(): bool
    {
        return $this->size === $this->capacity;
    }

    /**
     * Returns current queue size
     *
     * @return int
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * Returns queue capacity
     *
     * @return int
     */
    public function capacity(): int
    {
        return $this->capacity;
    }

    /**
     * Returns available queue size
     *
     * @return int
     */
    public function available(): int
    {
        return ($this->capacity !== 0) ? $this->capacity - $this->size : 0;
    }

    /**
     * Iterates over queue items and calls callback function for each item
     *
     * @param callable $callback
     * @param int $startIndex
     */
    public function forEach(callable $callback, int $startIndex = 0): void
    {
        for ($i = $startIndex; $i < $this->size; $i++) {
            $callback($this->items[$i], $i);
        }
    }

    public function getItems(): array
    {
        return $this->items;
    }
}