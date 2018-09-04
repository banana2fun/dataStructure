<?php

declare(strict_types=1);

namespace DataStructure\contracts;

interface DoublyLinkedListInterface
{
    public function pushFirst($value): void;

    public function pushLast($value): void;

    public function removeFirst();

    public function removeLast();

    public function isEmpty(): bool;

    public function at(int $index, bool $back);
}