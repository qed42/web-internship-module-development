<?php

namespace Drupal\Tests\virag_testing\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\virag_testing\Calculator;

/**
 * Provides kernel tests for the Calculator class.
 *
 * @group virag_testing
 */
class CalculatorKernelTest extends KernelTestBase {
  /**
   * The calculator service.
   *
   * @var \Drupal\virag_testing\Calculator
   */
  protected $calculator;

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();

    $module_installer = \Drupal::service('module_installer');
    $module_installer->install(['system', 'virag_testing']);

    // Explicitly load the module
    // $this->installConfig(['system']);
    // $this->container->get('module_installer')->install(['virag_testing']);.

    // Get the calculator service.
    $this->calculator = \Drupal::service('virag_testing.calculator');
  }

  /**
   * Test the calculator service is available.
   */
  public function testCalculatorServiceExists() {
    // $module_installer = \Drupal::service('module_installer');
    // $module_installer->install(['system']);

    $this->assertNotNull($this->calculator);
    $this->assertInstanceOf(Calculator::class, $this->calculator);
  }

  /**
   * Test basic calculator operations.
   */
  public function testCalculatorOperations() {
    $this->assertEquals(5, $this->calculator->add(2, 3));
    $this->assertEquals(6, $this->calculator->multiply(2, 3));
  }

}
