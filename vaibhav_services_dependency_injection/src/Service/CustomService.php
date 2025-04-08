<?php

namespace Drupal\vaibhav_services_dependency_injection\Service;

/**
 * This is demo Custom service for demonstrating dependency injection.
 */
class CustomService {

  /**
   * Returns a Hard coded technology-related message.
   *
   * This message will be displayed on the custom route.
   */
  public function getTechnologyMessage() {
    return "Did you know? Drupal is a powerful CMS that enables developers to build dynamic and flexible websites.
            It is open-source, written in PHP, and follows a modular architecture!";
  }

}
