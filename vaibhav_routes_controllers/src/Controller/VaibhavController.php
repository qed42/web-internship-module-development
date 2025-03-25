<?php

namespace Drupal\vaibhav_routes_controllers\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for route demonstrations.
 */
class VaibhavController extends ControllerBase {

  /**
   * Returns a simple message.
   */
  public function simpleMessage() {
    return [
      '#markup' => '<p>Welcome This is a college website developed by Vaibhav during the learning phase of Drupal!</p>',
    ];
  }

  /**
   * Returns a personalized message using a dynamic parameter.
   */
  public function dynamicMessage($name) {
    return [
      '#markup' => "<p>Hello, <strong>$name</strong>! This is a dynamic route.</p>",
    ];
  }

}
