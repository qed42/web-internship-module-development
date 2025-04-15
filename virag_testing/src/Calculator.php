<?php

namespace Drupal\virag_testing;

/**
 * Provides a simple calculator service for demonstrating different test types.
 */
class Calculator {

  /**
   * Adds two numbers together.
   *
   * @param int|float $a
   *   First number.
   * @param int|float $b
   *   Second number.
   *
   * @return int|float Sum of the two numbers.
   */
  public function add($a, $b) {
    return $a + $b;
  }

  /**
   * Subtracts the second number from the first.
   *
   * @param int|float $a
   *   First number.
   * @param int|float $b
   *   Number to subtract.
   *
   * @return int|float Difference between the numbers.
   */
  public function subtract($a, $b) {
    return $a - $b;
  }

  /**
   * Multiplies two numbers.
   *
   * @param int|float $a
   *   First number.
   * @param int|float $b
   *   Second number.
   *
   * @return int|float Product of the two numbers.
   */
  public function multiply($a, $b) {
    return $a * $b;
  }

  /**
   * Divides the first number by the second.
   *
   * @param int|float $a
   *   Numerator.
   * @param int|float $b
   *   Denominator.
   *
   * @return float|bool Result of division or false if dividing by zero
   *
   * @throws \InvalidArgumentException If $b is zero.
   */
  public function divide($a, $b) {
    if ($b == 0) {
      throw new \InvalidArgumentException("Cannot divide by zero");
    }
    return $a / $b;
  }

}
