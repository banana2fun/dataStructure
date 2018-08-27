<?php

namespace DataStructure\nodes;

class Node
{
    protected $value;
    protected $next;

    public function setNext(?Node $node = null): self
    {
        $this->next = $node;

        return $this;
    }

    public function getNext(): ?Node
    {
        return $this->next;
    }

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }
}