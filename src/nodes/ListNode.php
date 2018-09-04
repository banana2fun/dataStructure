<?php

namespace DataStructure\nodes;

class ListNode extends Node
{
    protected $previous;

    public function setPrevious(?Node $node = null): self
    {
        $this->previous = $node;

        return $this;
    }

    public function getPrevious(): ?Node
    {
        return $this->previous;
    }
}