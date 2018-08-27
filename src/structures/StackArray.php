<?php

declare(strict_types=1);

namespace DataStructure\structures;

use DataStructure\contracts\StackInterface;

class StackArray implements StackInterface
{
    public $stack;

    public function __construct(array $arr = [])
    {
        $this->stack = $arr;
    }

    public function top()
    {
        if ($this->isEmpty()) {
            throw new \Exception('Стопка пуста');
        }
        return current($this->stack);
    }

    public function push($value): void
    {
        if ($this->count() >= stackInterface::STACK_LIMIT) {
            throw new \Exception('Стопка максимального размера');
        }
        array_unshift($this->stack, $value);
    }

    public function count(): int
    {
        return count($this->stack);
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
        return array_shift($this->stack);
    }
}