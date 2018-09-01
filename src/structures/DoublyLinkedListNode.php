<?php

declare(strict_types=1);

namespace DataStructure\structures;

use DataStructure\contracts\DoublyLinkedListInterface;
use DataStructure\contracts\DoublyLinkedListNodeIterator;
use DataStructure\nodes\ListNode;

class DoublyLinkedListNode implements DoublyLinkedListInterface, \ArrayAccess, \IteratorAggregate
{
    /** @var ListNode */
    protected $first;
    /** @var ListNode */
    protected $last;
    public $count = 0;
    protected $position = 0;

    public function pushFirst($value): void
    {
        $node = new ListNode();
        $node->setValue($value);
        if ($this->isEmpty()) {
            $node->setPrevious()->setNext();
            $this->first = $this->last = $node;
        } else {
            $node->setNext($this->first);
            $this->first->setPrevious($node);
        }
        $this->first = $node;
        $this->count++;;
    }

    public function pushLast($value): void
    {
        $node = new ListNode();
        $node->setValue($value);
        if ($this->isEmpty()) {
            $node->setPrevious()->setNext();
            $this->first = $this->last = $node;
        } else {
            $node->setPrevious($this->last);
            $this->last->setNext($node);
        }
        $this->last = $node;
        $this->count++;
    }

    public function removeFirst()
    {
        if ($this->isEmpty()) {
            throw new \Exception('Список пуст');
        }
        if ($this->count === 1) {
            $this->first = $this->last = null;
            $this->count--;
            return null;
        }
        $c = $this->first;
        $this->first = $this->first->getNext();
        $this->first->setPrevious();
        $this->count--;
        return $c->getValue();
    }

    public function removeLast()
    {
        if ($this->isEmpty()) {
            throw new \Exception('Список пуст');
        }
        if ($this->count === 1) {
            $c = $this->first = $this->last = null;
            $this->count--;
            return null;
        }
        $c = $this->last;
        $this->last = $this->last->getPrevious();
        $this->last->setNext();
        $this->count--;
        return $c->getValue();
    }

    public function isEmpty(): bool
    {
        if ($this->count === 0) {
            return true;
        }
        return false;
    }

    public function at(int $index, bool $back)
    {
        $back === false ? $current = $this->first : $current = $this->last;
        $item = 1;
        while ($current) {
            if ($item === $index) {
                return $current->getValue();
            }
            $item++;
            $back === false ? $current = $current->getNext() : $current = $current->getPrevious();
        }
    }


    public function offsetExists($offset)
    {
        if ($offset >= $this->count || $offset < 0) {
            return false;
        }
        return true;
    }

    public function offsetGet($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new \Exception('Неверный номер элемента');
        }
        $current = $this->first;
       while (--$offset) {
            $current = $current->getNext();
        }
        return $current->getValue();
    }

    public function offsetSet($offset, $value)
    {
        if (!$this->offsetExists($offset)) {
            throw new \Exception('Неверный номер элемента');
        }
        $current = $this->first;
       while (--$offset) {
            $current = $current->getNext();
        }
        $current->setValue($value);
    }

    public function offsetUnset($offset)
    {
        if (!$this->offsetExists($offset)) {
            throw new \Exception('Неверный номер элемента');
        }
        if ($offset === 0 && $this->count !== 1) {
            $this->first = $this->first->getNext();
            $this->first->setPrevious();
        } elseif ($offset === $this->count - 1 && $this->count !== 1) {
            $this->last = $this->last->getPrevious();
            $this->last->setNext();
        } elseif ($this->count === 1) {
            $this->first = $this->last = null;
        } else {
            $current = $this->first;
            for ($i = 0; $i < $offset; $i++) {
                $current = $current->getNext();
            }
            /** @var ListNode $before */
            $before = $current->getPrevious();
            /** @var ListNode $after */
            $after = $current->getNext();
            $before->setNext($after);
            $after->setPrevious($before);
        }
        --$this->count;
    }

    public function getIterator()
    {
        return new DoublyLinkedListNodeIterator($this->first);
    }
}