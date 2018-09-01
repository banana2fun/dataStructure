<?php

declare(strict_types=1);

namespace Test\tests;

use DataStructure\contracts\DoublyLinkedListInterface;
use DataStructure\nodes\ListNode;
use DataStructure\structures\DoublyLinkedListNode;
use PHPUnit\Framework\TestCase;

class DoublyLinkedListNodeTest extends TestCase
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
        $this->assertEquals($this->list->at(1, false), $elementTwo);
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
        $this->assertEquals($this->list->at(1, false), $elementOne);
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
        $this->assertEquals($this->list->at(1, false), $elementOne);
    }

    public function testIsEmpty()
    {
        $this->assertTrue($this->list->isEmpty());
        $this->list->pushFirst(1);
        $this->assertFalse($this->list->isEmpty());
    }

    public function testCountPushAndRemove()
    {
        $this->assertEquals(0, $this->list->count);
        $elementOne = 1;
        $this->list->pushFirst($elementOne);
        $this->assertEquals(1, $this->list->count);
        $this->list->pushLast($elementOne);
        $this->assertEquals(2, $this->list->count);
        $this->list->removeFirst();
        $this->assertEquals(1, $this->list->count);
        $this->list->removeLast();
        $this->assertEquals(0, $this->list->count);
    }

    public function testOffsetExists()
    {
        $elementOne = 1;
        $this->list->pushFirst($elementOne);
        $this->assertEquals(true, $this->list->offsetExists(0));
        $this->assertEquals(false, $this->list->offsetExists(1));
    }

    public function testOffsetGetWithWrongOffset()
    {
        $this->expectException(\Exception::class);
        $this->list->offsetGet(1);
    }

    public function testOffsetGetWithRightOffset()
    {
        $elementOne = 1;
        $elementTwo = 2;
        $this->list->pushLast($elementOne);
        $this->list->pushLast($elementTwo);
        $this->assertEquals($elementOne, $this->list->offsetGet(1));
    }

    public function testOffsetSetWithWrongOffset()
    {
        $this->expectException(\Exception::class);
        $this->list->offsetSet(1, 1);
    }

    public function testOffsetSetWithRightOffset()
    {
        $elementOne = 1;
        $elementTwo = 2;
        $this->list->pushLast($elementOne);
        $this->list->pushLast($elementOne);
        $this->list->offsetSet(1, $elementTwo);
        $this->assertEquals($this->list->at(1, false), $elementTwo);
    }

    public function testOffsetUnsetWithWrongOffset()
    {
        $this->expectException(\Exception::class);
        $this->list->offsetUnset(1);
    }

    public function testOffsetUnsetWithOneElement()
    {
        $elementOne = 1;
        $this->list->pushFirst($elementOne);
        $this->list->offsetUnset(0);
        $this->assertEquals($this->list->at(1, false), null);
    }

    public function testOffsetUnsetFirstElement()
    {
        $elementOne = 1;
        $elementTwo = 2;
        $this->list->pushFirst($elementOne);
        $this->list->pushLast($elementTwo);
        $this->list->offsetUnset(0);
        $this->assertEquals($this->list->at(1, false), $elementTwo);
    }

    public function testOffsetUnsetLastElement()
    {
        $elementOne = 1;
        $elementTwo = 2;
        $this->list->pushFirst($elementOne);
        $this->list->pushLast($elementTwo);
        $this->assertEquals($this->list->at(2, false), $elementTwo);
        $this->list->offsetUnset(1);
        $this->assertEquals($this->list->at(2, false), null);
    }

    public function testOffsetUnsetAnyElement()
    {
        $elementOne = 1;
        $elementTwo = 2;
        $elementThree = 3;
        $this->list->pushLast($elementOne);
        $this->list->pushLast($elementTwo);
        $this->list->pushLast($elementThree);
        $this->assertEquals($this->list->at(2, false), $elementTwo);
        $this->list->offsetUnset(1);
        $this->assertEquals($this->list->at(2, false), $elementThree);
    }


}