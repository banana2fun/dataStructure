<?php

namespace DataStructure\nodes;

class TreeNode
{
    protected $left;
    protected $right;
    protected $value;
    protected $count = 0;

    public function setRight(?TreeNode $node = null): self
    {
        $this->right = $node;

        return $this;
    }

    public function getRight(): ?TreeNode
    {
        return $this->right;
    }

    public function setLeft(?TreeNode $node = null): self
    {
        $this->left = $node;

        return $this;
    }

    public function getLeft(): ?TreeNode
    {
        return $this->left;
    }

    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function increaseCounter(): self
    {
        ++$this->count;
        return $this;
    }
}