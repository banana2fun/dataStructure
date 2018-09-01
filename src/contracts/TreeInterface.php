<?php

declare(strict_types=1);

namespace DataStructure\contracts;

interface TreeInterface
{
    public function isEmpty(): bool;

    public function push(int $value): void;

    public function searchMax(): int;

    public function searchMin(): int;

    public function elementCount(int $value): int;

    public function detour(bool $descending): void;

    public function deleteElement(int $value): void;
}