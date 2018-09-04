<?php

declare(strict_types=1);

namespace DataStructure\structures;

use DataStructure\contracts\QueueInterface;
use DataStructure\nodes\Node;

class QueueNode implements QueueInterface
{
    /** @var Node */
    protected $last;
    /** @var Node */
    protected $first;

    public function peek()
    {
        if ($this->isEmpty()) {
            throw new \Exception('Очередь пуста');
        }
        return $this->first->getValue();
    }

    public function push($value): void
    {
        if ($this->count() >= QueueInterface::QUEUE_LIMIT) {
            throw new \Exception('Очередь максимального размера');
        }
        $node = new Node();
        $node->setValue($value);
        $this->isEmpty() ? $this->first = $node : $this->last->setNext($node);
        $this->last = $node;
    }

    public function count(): int
    {
        $current = $this->first;
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
            throw new \Exception('Очередь пуста');
        }
        $c = $this->first;
        $this->first = $this->first->getNext();
        return $c->getValue();
    }
}