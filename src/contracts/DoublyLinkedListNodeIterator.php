<?php

namespace DataStructure\contracts;

use DataStructure\nodes\ListNode;

class DoublyLinkedListNodeIterator implements \Iterator
{
    protected $first;
    /** @var ListNode */
    protected $current;

    public function __construct($node)
    {
        $this->first = $this->current = $node;
    }

    public function current()
    {
        return $this->current->getValue();
    }

    public function key()
    {
        return '';
    }

    public function next()
    {
        $this->current = $this->current->getNext();
    }

    public function rewind()
    {
        $this->current = $this->first;
    }

    public function valid()
    {
        return isset($this->current);
    }
}