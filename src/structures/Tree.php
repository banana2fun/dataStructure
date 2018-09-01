<?php

declare(strict_types=1);

namespace DataStructure\structures;

use DataStructure\contracts\TreeInterface;
use DataStructure\nodes\TreeNode;
use PHPUnit\Runner\Exception;

class Tree implements TreeInterface
{
    /** @var TreeNode */
    protected $root;

    public function isEmpty(): bool
    {
        if ($this->root === null) {
            return true;
        }
        return false;
    }

    public function push(int $value): void
    {
        $this->pushNode($value, $this->root);
    }

    public function searchMax(): int
    {
        if ($this->isEmpty()) {
            throw new Exception('Дерево пустое');
        }
        $max = $this->root->getValue();
        $current = $this->root;
        while ($current->getRight() !== null) {
            $max = $current->getValue();
            $current = $current->getRight();
            if ($current->getRight() === null) {
                $max = $current->getValue();
            }
        }
        return $max;
    }

    public function searchMin(): int
    {
        if ($this->isEmpty()) {
            throw new Exception('Дерево пустое');
        }
        $min = $this->root->getValue();
        $current = $this->root;
        while ($current->getLeft() !== null) {
            $min = $current->getValue();
            $current = $current->getLeft();
            if ($current->getLeft() === null) {
                $min = $current->getValue();
            }
        }
        return $min;
    }

    public function elementCount(int $value): int
    {
        if ($this->isEmpty()) {
            throw new Exception('Дерево пустое');
        }
        return $this->numberOfElementExistence($value, $this->root);
    }

    public function detour(bool $descending): void
    {
        if ($this->isEmpty()) {
            throw new Exception('Дерево пустое');
        }
        if ($descending) {
            $this->detourInDescendingOrder($this->root, 0);
        } else {
            $this->detourInIncreaseOrder($this->root, 0);
        }
    }

    public function deleteElement(int $value): void
    {
        if ($this->isEmpty()) {
            throw new Exception('Дерево пустое');
        }
        if ($this->elementCount($value) === 0) {
            throw new Exception('Удаляемый элемент не обнаружен');
        }
        $branch = $this->deleteBranch($value, $this->root);
        $this->pushBranchWithoutRootNode($value, $branch);
    }

    protected function pushNode(int $value, ?TreeNode $root = null, ?TreeNode $parent = null): void
    {
        if ($this->isEmpty()) {
            $node = new TreeNode();
            $node->setValue($value)->setLeft()->setRight()->increaseCounter();
            $this->root = $node;
        } elseif ($root === null) {
            $node = new TreeNode();
            $node->setValue($value)->setLeft()->setRight()->increaseCounter();
            if ($value > $parent->getValue()) {
                $parent->setRight($node);
            } else {
                $parent->setLeft($node);
            }
        } else {
            if ($root->getValue() === $value) {
                $root->increaseCounter();
            } else {
                if ($root->getValue() > $value) {
                    $this->pushNode($value, $root->getLeft(), $root);
                } else {
                    $this->pushNode($value, $root->getRight(), $root);
                }
            }
        }
    }

    protected function numberOfElementExistence(int $value, ?TreeNode $root): int
    {
        if ($root === null) {
            return 0;
        }
        if ($root->getValue() === $value) {
            return $root->getCount();
        }
        if ($root->getValue() > $value) {
            return $this->numberOfElementExistence($value, $root->getLeft());
        } elseif ($root->getValue() < $value) {
            return $this->numberOfElementExistence($value, $root->getRight());
        }
    }

    protected function detourInDescendingOrder(?TreeNode $root, int $level): void
    {
        if ($root !== null) {
            $this->detourInDescendingOrder($root->getLeft(), $level + 1);
            $string = '';
            for ($i = 0; $i < $level; $i++) {
                $string .= '    ';
            }
            echo $string . $root->getValue() . PHP_EOL;
            $this->detourInDescendingOrder($root->getRight(), $level + 1);
        }
    }

    protected function detourInIncreaseOrder(?TreeNode $root, int $level): void
    {
        if ($root !== null) {
            $this->detourInIncreaseOrder($root->getRight(), $level + 1);
            $string = '';
            for ($i = 0; $i < $level; $i++) {
                $string .= '    ';
            }
            echo $string . $root->getValue() . PHP_EOL;
            echo $root->getValue();
            $this->detourInIncreaseOrder($root->getLeft(), $level + 1);
        }
    }

    protected function deleteBranch($value, ?TreeNode $root): ?TreeNode
    {
        if ($root !== null) {
            $rootValue = $root->getValue();
            $left = $root->getLeft();
            $right = $root->getRight();
            if ($left !== null && $left->getValue() === $value) {
                $root->setLeft();
                return $left;
            } elseif ($right !== null && $right->getValue() === $value) {
                $root->setRight();
                return $right;
            }
            if ($rootValue === $value) {
                $this->root = null;
                return $root;
            } elseif ($rootValue > $value) {
                return $this->deleteBranch($value, $left);
            } elseif ($rootValue < $value) {
                return $this->deleteBranch($value, $right);
            }
        }
    }

    protected function pushBranchWithoutRootNode($value, ?TreeNode $branch): void
    {
        if ($branch !== null) {
            if ($branch->getValue() !== $value) {
                $this->push($branch->getValue());
            }
            $this->pushBranchWithoutRootNode($value, $branch->getRight());
            $this->pushBranchWithoutRootNode($value, $branch->getLeft());
        }
    }
}