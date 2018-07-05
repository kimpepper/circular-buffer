<?php

namespace CircularBuffer;

use UnderflowException;

/**
 * Simple in-memory Circular Buffer.
 */
class MemoryCircularBuffer implements CircularBufferInterface {

  /**
   * The maximum size of the buffer.
   *
   * @var int
   */
  protected $maxSize;

  /**
   * The buffer.
   *
   * @var array
   */
  protected $buffer;

  /**
   * The next free position in the buffer.
   *
   * @var int
   */
  protected $position;

  /**
   * The actual size of the buffer.
   *
   * @var int
   */
  protected $size;

  /**
   * CircularBuffer constructor.
   *
   * @param int $maxSize
   *   The maximum size.
   */
  public function __construct(int $maxSize) {
    $this->maxSize = $maxSize;
    $this->buffer = [];
    $this->position = 0;
    $this->size = 0;
  }

  /**
   * {@inheritdoc}
   */
  public function add(int $item) {
    $this->buffer[$this->position] = $item;
    $this->position = ($this->position + 1) % $this->maxSize;
    $this->size = min($this->size + 1, $this->maxSize);
  }

  /**
   * {@inheritdoc}
   */
  public function get() {
    if ($this->isEmpty()) {
      throw new UnderflowException("Buffer is empty");
    }
    return $this->buffer[$this->getLeastRecentPosition()];
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    return $this->size == 0;
  }

  /**
   * {@inheritdoc}
   */
  public function isFull() {
    return $this->size == $this->maxSize;
  }

  /**
   * {@inheritdoc}
   */
  public function clear() {
    $this->size = 0;
    $this->position = 0;
    $this->buffer = [];
  }

  /**
   * {@inheritdoc}
   */
  public function remove() {

    if ($this->isEmpty()) {
      throw new UnderflowException("Buffer is empty");
    }

    $leastRecentPosition = $this->getLeastRecentPosition();
    $leastRecentElement = $this->buffer[$leastRecentPosition];
    unset($this->buffer[$leastRecentPosition]);
    $this->size--;

    return $leastRecentElement;
  }

  /**
   * {@inheritdoc}
   */
  public function average() {
    return array_sum($this->buffer) / $this->size;
  }

  /**
   * {@inheritdoc}
   */
  public function count() {
    return $this->size;
  }

  /**
   * {@inheritdoc}
   */
  public function getIterator() {
    return new MemoryCircularBufferIterator(
      $this->buffer,
      $this->getLeastRecentPosition(),
      $this->size
    );
  }

  /**
   * Returns the position of the least recently added element in the buffer.
   *
   * @return int
   *   Position of the least recently added element
   */
  protected function getLeastRecentPosition() {
    $position = $this->position - $this->size;
    // PHP's modulo is broken: Negative numbers aren't handled properly.
    // Adding maxSize solves this.
    $position += $this->maxSize;
    return $position % $this->maxSize;
  }

}
