<?php

namespace Drupal\vaibhav_state_api\State;

use Drupal\Core\KeyValueStore\KeyValueFactoryInterface;

/**
 * State manager for custom state storage.
 */
class StateManager {

  /**
   * The key value factory.
   *
   * @var \Drupal\Core\KeyValueStore\KeyValueFactoryInterface
   */
  protected $keyValue;

  /**
   * Constructs a StateManager object.
   *
   * @param \Drupal\Core\KeyValueStore\KeyValueFactoryInterface $key_value
   *   The key value factory.
   */
  public function __construct(KeyValueFactoryInterface $key_value) {
    $this->keyValue = $key_value;
  }

  /**
   * Gets a value from storage.
   *
   * @param string $key
   *   The key to retrieve.
   *
   * @return mixed
   *   The stored value, or NULL if not found.
   */
  public function get($key) {
    return $this->keyValue->get('vaibhav_state')->get($key);
  }

  /**
   * Sets a value in storage.
   *
   * @param string $key
   *   The key to set.
   * @param mixed $value
   *   The value to store.
   */
  public function set($key, $value) {
    $this->keyValue->get('vaibhav_state')->set($key, $value);
  }

  /**
   * Deletes a value from storage.
   *
   * @param string $key
   *   The key to delete.
   */
  public function delete($key) {
    $this->keyValue->get('vaibhav_state')->delete($key);
  }

}
