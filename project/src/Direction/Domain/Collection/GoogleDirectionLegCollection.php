<?php

namespace Direction\Domain\Collection;

class GoogleDirectionLegCollection extends Collection
{

    public function addItem($item)
    {
        $this->offsetSet($this->count(), $item);
    }
}