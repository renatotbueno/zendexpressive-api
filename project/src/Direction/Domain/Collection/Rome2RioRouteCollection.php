<?php

namespace Direction\Domain\Collection;

class Rome2RioRouteCollection extends Collection
{

    public function addItem($item)
    {
        $this->offsetSet($this->count(), $item);
    }

    public function toArray()
    {
        $arr = [];
        if ($this->items) {
            /**
             * @var GoogleDirectionRouteCollection $item
             */
            foreach ($this->items as $item) {
                $arr[] = $item->toArray();
            }
        }

        return $arr;
    }
}