<?php

namespace DataStructure\contracts;

interface StackInterface
{
    public const STACK_LIMIT = 100;

    public function top();

    public function push($value): void;

    public function count(): int;

    public function isEmpty(): bool;

    public function pop();
}

