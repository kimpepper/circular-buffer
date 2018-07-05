<?php

namespace CircularBuffer\Tests\Unit;

use CircularBuffer\MemoryCircularBuffer;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CircularBuffer\MemoryCircularBuffer
 */
class MemoryCircularBufferTest extends TestCase {

  /**
   * @covers ::__contruct()
   * @covers ::add()
   * @covers ::average()
   * @covers ::count()
   */
  public function testBufferOverflow() {

    $items = [4, 7, 9, 12, 14];
    $maxSize = 3;

    $buffer = new MemoryCircularBuffer($maxSize);

    $this->assertCount(0, $buffer);

    $buffer->add($items[0]);
    $this->assertCount(1, $buffer);
    $this->assertEquals(4, $buffer->average());

    $buffer->add($items[1]);
    $this->assertCount(2, $buffer);
    $this->assertEquals(5.5, $buffer->average());

    $buffer->add($items[2]);
    $this->assertCount(3, $buffer);
    $this->assertEquals(6.67, $buffer->average(), NULL, 0.01);

    // Check we overflow.
    $buffer->add($items[3]);
    $this->assertCount(3, $buffer);
    $this->assertEquals(9.33, $buffer->average(), NULL, 0.01);

    $buffer->add($items[4]);
    $this->assertCount(3, $buffer);
    $this->assertEquals(11.67, $buffer->average(), NULL, 0.01);

    // Test the iterator.
    $expected = [9, 12, 14];
    $actual = [];
    foreach ($buffer as $key => $item) {
      $actual[$key] = $item;
    }

    $this->assertEquals($expected, $actual);

  }

}
