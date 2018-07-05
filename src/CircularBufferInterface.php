<?php

namespace CircularBuffer;

use Countable;
use IteratorAggregate;

/**
 * Interface for Circular Buffer implementations.
 */
interface CircularBufferInterface extends Countable, IteratorAggregate {

  /**
   * Adds an item to the circular buffer.
   *
   * @param int $item
   *   The item.
   */
  public function add(int $item);

  /**
   * Gets the average of all items in the circular buffer.
   *
   * @return float
   *   The average.
   */
  public function average();

  /**
   * Gets the least recently added element.
   *
   * @return int
   *   The least recently added element
   *
   * @throws \UnderflowException
   *   The exception is thrown when the buffer is empty.
   */
  public function get();

  /**
   * Returns whether the buffer is empty.
   *
   * @return bool
   *   True when the buffer is empty, false otherwise.
   */
  public function isEmpty();

  /**
   * Returns whether the buffer is full.
   *
   * @return bool
   *   True when the buffer is full, false otherwise.
   */
  public function isFull();

  /**
   * Clears the buffer of all elements.
   */
  public function clear();

  /**
   * Removes and returns the least recently added element.
   *
   * @return int
   *   The least recently added element.
   *
   * @throws \UnderflowException
   *   The exception is thrown when the buffer is empty.
   */
  public function remove();

}
