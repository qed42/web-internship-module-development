<?php

namespace Drupal\Tests\virag_testing\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Provides a functional test for the Virag Testing module.
 *
 * @group virag_testing
 */
class ViragTestingFunctionalTest extends BrowserTestBase {
  /**
   * Modules to install.
   *
   * @var array
   */
  protected static $modules = ['virag_testing'];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Test that the module can be installed.
   */
  public function testModuleInstallation() {
    $this->assertTrue(\Drupal::moduleHandler()->moduleExists('virag_testing'), 'Module is installed successfully.');
  }

}
