<?php

declare(strict_types=1);

namespace DataStructure\structures;

use DataStructure\contracts\QueueInterface;

class QueueArray implements QueueInterface
{
    protected $queue = [];

    public function peek()
    {
        if ($this->isEmpty()) {
            throw new \Exception('Очередь пуста');
        }
        return reset($this->queue);
    }

    public function push($value): void
    {
        if ($this->count() >= QueueInterface::QUEUE_LIMIT) {
            throw new \Exception('Очередь максимального размера');
        }
        array_push($this->queue, $value);
    }

    public function count(): int
    {
        return count($this->queue);
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
        return array_shift($this->queue);
    }
}