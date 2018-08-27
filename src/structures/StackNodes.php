<?php

declare(strict_types=1);

namespace DataStructure\structures;

use DataStructure\contracts\StackInterface;
use DataStructure\nodes\Node;

class StackNodes implements StackInterface
{
    /** @var Node */
    protected $top;

    public function top()
    {
        if ($this->isEmpty()) {
            throw new \Exception('Стопка пуста');
        }
        return $this->top->getValue();
    }

    public function push($value): void
    {
        if ($this->count() >= stackInterface::STACK_LIMIT) {
            throw new \Exception('Стопка максимального размера');
        }
        $node = new Node();
        $node->setValue($value)->setNext($this->top);
        $this->top = $node;
    }

    public function count(): int
    {
        $current = $this->top;
        $count = 0;
        while ($current) {
            $count++;
            $current = $current->getNext();
        }
        return $count;
    }

    public function isEmpty(): bool
    {
        if ($this->count() === 0) {
            return true;
        }
        return false;
    }

    public function pop()
    {
        if ($this->isEmpty()) {
            throw new \Exception('Стопка пуста');
        }
        $c = $this->top;
        $this->top = $this->top->getNext();
        return $c->getValue();
    }
}