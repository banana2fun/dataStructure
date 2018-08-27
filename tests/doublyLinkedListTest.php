<?php

declare(strict_types=1);

namespace Test\tests;

use DataStructure\contracts\DoublyLinkedListInterface;
use DataStructure\nodes\ListNode;
use DataStructure\structures\DoublyLinkedListNode;
use PHPUnit\Framework\TestCase;

class DoublyLinkedListInterfaceTest extends TestCase
{
    /** @var DoublyLinkedListNode */
    private $list;

    protected function setUp()
    {
        parent::setUp();
        $this->list = new DoublyLinkedListNode();
    }

    public function testPushFirst()
    {
        $elementOne = 1;
        $elementTwo = 2;
        $this->list->pushFirst($elementOne);
        $this->list->pushFirst($elementTwo);
        $this->assertEquals($this->list->at(1), $elementTwo);
    }

    public function testPushLast()
    {
        $elementOne = 1;
        $elementTwo = 2;
        $this->list->pushLast($elementOne);
        $this->list->pushLast($elementTwo);
        $this->assertEquals($this->list->at(1, true), $elementTwo);
    }

    public function testRemoveFirstWithEmptyList()
    {
        $this->expectException(\Exception::class);
        $this->list->removeFirst();
    }

    public function testRemoveFirstWithNotEmptyList()
    {
        $elementOne = 1;
        $elementTwo = 2;
        $this->list->pushFirst($elementOne);
        $this->list->pushFirst($elementTwo);
        $this->list->removeFirst();
        $this->assertEquals($this->list->at(1), $elementOne);
    }

    public function testRemoveLastWithEmptyList()
    {
        $this->expectException(\Exception::class);
        $this->list->removeLast();
    }

    public function testRemoveLastWithNotEmptyList()
    {
        $elementOne = 1;
        $elementTwo = 2;
        $this->list->pushLast($elementOne);
        $this->list->pushLast($elementTwo);
        $this->list->removeLast();
        $this->assertEquals($this->list->at(1), $elementOne);
    }

    public function testIsEmpty()
    {
        $this->assertTrue($this->list->isEmpty());
        $this->list->pushFirst(1);
        $this->assertFalse($this->list->isEmpty());
    }

}