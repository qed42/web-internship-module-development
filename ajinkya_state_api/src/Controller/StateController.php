<?php

namespace Drupal\ajinkya_state_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\ajinkya_state_api\Service\ExampleStateService;

/**
 * Returns responses for the State API example.
 */
class StateController extends ControllerBase {

  /**
   * The state service.
   *
   * @var \Drupal\ajinkya_state_api\Service\ExampleStateService
   */
  protected $exampleStateService;

  /**
   * Constructs a StateController object.
   *
   * @param \Drupal\ajinkya_state_api\Service\ExampleStateService $exampleStateService
   *   The example state service.
   */
  public function __construct(ExampleStateService $exampleStateService) {
    $this->exampleStateService = $exampleStateService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('ajinkya_state_api.example_service')
    );
  }

  /**
   * Stores a value and returns confirmation.
   */
  public function setState() {
    $this->exampleStateService->setCustomStateValue('Hello, Ajinkya!');
    return [
      '#markup' => 'State value has been set successfully!',
    ];
  }

  /**
   * Retrieves and displays the stored state value.
   */
  public function getState() {
    $value = $this->exampleStateService->getCustomStateValue();
    return [
      '#markup' => "Stored value: $value",
    ];
  }

}
