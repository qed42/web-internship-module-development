<?php

namespace Drupal\Tests\virag_testing\Unit;

use Drupal\virag_testing\Calculator;
use Drupal\Tests\UnitTestCase;

/**
 * Provides unit tests for the Calculator class.
 *
 * @group virag_testing
 */
class CalculatorUnitTest extends UnitTestCase {
  /**
   * The calculator instance to test.
   *
   * @var \Drupal\virag_testing\Calculator
   */
  protected $calculator;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->calculator = new Calculator();
  }

  /**
   * Test the add method.
   */
  public function testAdd() {
    $this->assertEquals(5, $this->calculator->add(2, 3));
    $this->assertEquals(-1, $this->calculator->add(-4, 3));
    $this->assertEquals(0, $this->calculator->add(0, 0));
  }

  /**
   * Test the subtract method.
   */
  public function testSubtract() {
    $this->assertEquals(-1, $this->calculator->subtract(2, 3));
    $this->assertEquals(-7, $this->calculator->subtract(-4, 3));
    $this->assertEquals(0, $this->calculator->subtract(0, 0));
  }

  /**
   * Test the multiply method.
   */
  public function testMultiply() {
    $this->assertEquals(6, $this->calculator->multiply(2, 3));
    $this->assertEquals(-12, $this->calculator->multiply(-4, 3));
    $this->assertEquals(0, $this->calculator->multiply(0, 5));
  }

  /**
   * Test the divide method.
   */
  public function testDivide() {
    $this->assertEquals(2, $this->calculator->divide(6, 3));

    $this->expectException(\InvalidArgumentException::class);
    $this->calculator->divide(5, 0);
  }

}
