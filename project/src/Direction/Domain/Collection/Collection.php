<?php

namespace Direction\Domain\Collection;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;

class Collection implements Countable, IteratorAggregate, ArrayAccess
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * Retrieve an external iterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Whether a offset exists
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * Offset to retrieve
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->items[$offset] : null;
    }

    /**
     * Offset to set
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * Offset to unset
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->items[$offset]);
        }
    }

    /**
     * Current element of an object
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * Count elements of an object
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Transform collection in array
     * @return array
     */
    public function toArray()
    {
        return array_map(function ($item) {
            return $item->toArray();
        }, $this->items);
    }

    /**
     * Transform collection in json
     * @return array
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * @param $key
     * @return Entity
     */
    public function getItem($key)
    {
        return $this->offsetGet($key);
    }

    /**
     * @param $key
     */
    public function removeItem($key)
    {
        $this->offsetUnset($key);
    }
}