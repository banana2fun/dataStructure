<?php

namespace DataStructure\contracts;

interface QueueInterface
{
    public const QUEUE_LIMIT = 100;

    public function peek();

    public function push($value): void;

    public function count(): int;

    public function isEmpty(): bool;

    public function pop();
}