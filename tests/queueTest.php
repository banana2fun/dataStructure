<?php

namespace Test\tests;

use DataStructure\contracts\QueueInterface;
use DataStructure\structures\Queue;
use PHPUnit\Framework\TestCase;

class QueueTest extends TestCase
{
    /** @var Queue */
    protected $queue;


    protected function setUp()
    {
        parent::setUp();
        $this->queue = new Queue();
    }

    public function testPeekWithEmptyQueue()
    {
        $this->expectException(\Exception::class);
        $this->queue->peek();
    }

    public function testPeekWithNotEmptyQueue()
    {
        $elementOne = 1;
        $this->queue->push($elementOne);
        $this->assertEquals($elementOne, $this->queue->peek());
        $elementTwo = 2;
        $this->queue->push($elementTwo);
        $this->assertEquals($elementOne, $this->queue->peek());
    }

    public function testCountWithNotEmptyQueue()
    {
        $count = 50;
        for ($i = 0; $i < $count; $i++) {
            $this->queue->push($i);
        }
        $this->assertEquals($count, $this->queue->count());
    }

    public function testCountWithEmptyQueue()
    {
        $this->assertEquals(0, $this->queue->count());
    }

    public function testIsEmpty()
    {
        $this->assertTrue($this->queue->isEmpty());
        $this->queue->push(1);
        $this->assertFalse($this->queue->isEmpty());
    }

    public function testPopWithEmptyQueue()
    {
        $this->expectException(\Exception::class);
        $this->queue->pop();
    }

    public function testPopWithNotEmptyQueue()
    {
        $count = 50;
        for ($i = 0; $i < $count; $i++) {
            $this->queue->push($i);
        }
        for ($i = 0; $i < $count; $i++) {
            $this->assertEquals($i, $this->queue->pop());
        }
    }

    public function testQueueLimit()
    {
        $this->expectException(\Exception::class);
        for ($i = 0; $i < QueueInterface::QUEUE_LIMIT + 1; $i++) {
            $this->queue->push($i);
        }
    }
}