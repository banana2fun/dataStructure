<?php
declare(strict_types=1);

namespace Test\tests;

use DataStructure\contracts\StackInterface;
use DataStructure\structures\Stack;
use DataStructure\structures\StackNodes;
use PHPUnit\Framework\TestCase;

class StackTest extends TestCase
{
    /** @var StackNodes */
    private $stack;

    protected function setUp()
    {
        parent::setUp();
        $this->stack = new Stack();
    }

    public function testCountWithEmptyStack(): void
    {
        $actualCount = $this->stack->count();
        $this->assertEquals(0, $actualCount);
    }

    public function testCountWithNotEmptyStack(): void
    {
        $expectedCount = 100;
        for ($i = 1; $i <= $expectedCount; $i++) {
            $this->stack->push($i);
        }
        $actualCount = $this->stack->count();
        $this->assertEquals($expectedCount, $actualCount);
    }

    public function testIsEmpty(): void
    {
        $this->assertTrue($this->stack->isEmpty());
        $this->stack->push(1);
        $this->assertFalse($this->stack->isEmpty());
    }

    public function testPush(): void
    {
        $elementOne = 1;
        $elementTwo = 2;
        $this->stack->push($elementOne);
        $this->assertEquals($this->stack->top(), $elementOne);
        $this->stack->push($elementTwo);
        $this->assertEquals($this->stack->top(), $elementTwo);
    }

    public function testStackLimit(): void
    {
        $this->expectException(\Exception::class);
        for ($i = 0; $i < StackInterface::STACK_LIMIT + 1; $i++) {
            $this->stack->push($i);
        }
    }

    public function testTopWithEmptyStack(): void
    {
        $this->expectException(\Exception::class);
        $this->stack->top();
    }

    public function testTopWithNotEmptyStack(): void
    {
        $elementOne = 1;
        $this->stack->push($elementOne);
        $this->assertEquals($elementOne, $this->stack->top());
    }

    public function testPopWithEmptyStack(): void
    {
        $this->expectException(\Exception::class);
        $this->stack->pop();
    }

    public function testPopWithNotEmptyStack(): void
    {
        $elementOne = 1;
        $elementTwo = 2;
        $this->stack->push($elementOne);
        $this->stack->push($elementTwo);
        $this->assertEquals($elementTwo, $this->stack->top());
        $this->assertEquals($elementTwo, $this->stack->pop());
        $this->assertNotEquals($elementTwo, $this->stack->top());
        $this->assertEquals($elementOne, $this->stack->pop());
    }
}