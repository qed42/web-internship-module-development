<?php

namespace Drupal\ajinkya_state_api\Service;

use Drupal\Core\State\StateInterface;

/**
 * Provides an example service that uses the State API.
 */
class ExampleStateService {

  /**
   * The state API service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Constructs the ExampleStateService.
   *
   * @param \Drupal\Core\State\StateInterface $state
   *   The state API service.
   */
  public function __construct(StateInterface $state) {
    $this->state = $state;
  }

  /**
   * Stores a value in the State API.
   *
   * @param string $value
   *   The value to store.
   */
  public function setCustomStateValue($value) {
    $this->state->set('ajinkya_state_api.custom_value', $value);
  }

  /**
   * Retrieves the stored value from the State API.
   *
   * @return string|null
   *   The stored value or NULL if not set.
   */
  public function getCustomStateValue() {
    return $this->state->get('ajinkya_state_api.custom_value', 'Default Value');
  }

}
