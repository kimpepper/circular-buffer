<?php

namespace CircularBuffer;

use Iterator;

/**
 * Iterator for MemoryCircularBuffer.
 */
class MemoryCircularBufferIterator implements Iterator {

  /**
   * The iterator's position.
   *
   * @var int
   */
  protected $position = 0;

  /**
   * The offset in the array of position in relation to the real start index.
   *
   * @var int
   */
  protected $offset;

  /**
   * The number of elements in the buffer.
   *
   * @var int
   */
  protected $size;

  /**
   * The actual array of elements (internal representation of the buffer).
   *
   * @var array
   */
  protected $buffer;

  /**
   * The size of the array.
   *
   * @var int
   */
  protected $bufferSize;

  /**
   * MemoryCircularBufferIterator constructor.
   *
   * @param array $buffer
   *   The buffer.
   * @param int $startPosition
   *   The offset in the array of position in relation to the real start index.
   * @param int $size
   *   The number of elements in the buffer.
   */
  public function __construct(array $buffer, int $startPosition, int $size) {
    $this->offset = $startPosition;
    $this->size = $size;
    $this->buffer = $buffer;
    $this->bufferSize = count($buffer);
  }

  /**
   * {@inheritdoc}
   */
  public function current() {
    $realPosition = ($this->offset + $this->position) % $this->bufferSize;
    return $this->buffer[$realPosition];
  }

  /**
   * {@inheritdoc}
   */
  public function next() {
    $this->position++;
  }

  /**
   * {@inheritdoc}
   */
  public function key() {
    return $this->position;
  }

  /**
   * {@inheritdoc}
   */
  public function valid() {
    return $this->position < $this->size;
  }

  /**
   * {@inheritdoc}
   */
  public function rewind() {
    $this->position = 0;
  }

}
