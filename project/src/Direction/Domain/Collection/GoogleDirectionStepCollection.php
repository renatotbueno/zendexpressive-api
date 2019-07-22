<?php

namespace Direction\Domain\Collection;

class GoogleDirectionStepCollection extends Collection
{

    public function addItem($item)
    {
        $this->offsetSet($this->count(), $item);
    }
}