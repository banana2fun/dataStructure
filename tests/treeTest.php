<?php

declare(strict_types=1);

namespace Test\tests;

use DataStructure\structures\Tree;
use PHPUnit\Framework\TestCase;

class TreeTest extends TestCase
{
    /** @var Tree */
    private $tree;

    protected function setUp()
    {
        parent::setUp();
        $this->tree = new Tree();
    }

    public function testIsEmptyAndPush()
    {
        $this->assertTrue($this->tree->isEmpty());
        $this->tree->push(1);
        $this->assertFalse($this->tree->isEmpty());
    }

    public function testSearchMaxWithEmptyTree()
    {
        $this->expectException(\Exception::class);
        $this->tree->searchMax();
    }

    public function testSearchMaxWithNotEmptyTree()
    {
        $this->tree->push(34);
        $this->tree->push(56);
        $this->tree->push(3);
        $this->assertEquals(56, $this->tree->searchMax());
    }

    public function testSearchMinWithEmptyTree()
    {
        $this->expectException(\Exception::class);
        $this->tree->searchMin();
    }

    public function testSearchMinWithNotEmptyTree()
    {
        $this->tree->push(34);
        $this->tree->push(56);
        $this->tree->push(3);
        $this->assertEquals(3, $this->tree->searchMin());
    }

    public function testElementCountWithEmptyTree() {
        $this->expectException(\Exception::class);
        $this->tree->elementCount(3);
    }

    public function testElementCountWithNotEmptyTree()
    {
        $this->tree->push(34);
        $this->tree->push(3);
        $this->tree->push(56);
        $this->tree->push(3);
        $this->assertEquals(2, $this->tree->elementCount(3));
        $this->assertEquals(0, $this->tree->elementCount(1));
    }

    public function testDetourWithEmptyTree() {
        $this->expectException(\Exception::class);
        $this->tree->detour(true);
        $this->tree->detour(false);
    }

//    public function testDetourWithNotEmptyTree()
//    {
//
//    }

    public function testDeleteElementWithEmptyTree()
    {
        $this->expectException(\Exception::class);
        $this->tree->deleteElement(3);
    }

    public function testDeleteMissingElementWithNotEmptyTree()
    {
        $this->tree->push(34);
        $this->tree->push(3);
        $this->tree->push(56);
        $this->expectException(\Exception::class);
        $this->tree->deleteElement(4);
    }

    public function testDeleteElementWithNotEmptyTree()
    {
        $this->tree->push(34);
        $this->tree->push(3);
        $this->tree->push(56);
        $this->assertEquals(3, $this->tree->searchMin());
        $this->tree->deleteElement(3);
        $this->assertEquals(34, $this->tree->searchMin());
    }
}