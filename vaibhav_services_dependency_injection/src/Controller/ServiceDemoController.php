<?php

namespace Drupal\vaibhav_services_dependency_injection\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\vaibhav_services_dependency_injection\Service\CustomService;

/**
 * Controller to demonstrate dependency injection.
 */
class ServiceDemoController extends ControllerBase {

  /**
   * This is a custom service.
   *
   * @var \Drupal\vaibhav_services_dependency_injection\Service\CustomService
   */
  protected $customService;

  /**
   * Constructs a ServiceDemoController object.
   */
  public function __construct(CustomService $custom_service) {
    $this->customService = $custom_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('vaibhav_services_dependency_injection.custom_service')
    );
  }

  /**
   * Returns a page with a hard coded message.
   */
  public function showMessage() {
    $message = $this->customService->getTechnologyMessage();
    return [
      '#theme' => 'item_list',
      '#items' => [$message],
      '#title' => 'Technology Fact',
    ];
  }

}
