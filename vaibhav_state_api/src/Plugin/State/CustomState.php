<?php

namespace Drupal\vaibhav_state_api\Plugin\State;

use Drupal\Core\State\StateInterface;
use Drupal\Core\Plugin\PluginBase;
use Drupal\vaibhav_state_api\State\StateManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a custom state manager.
 *
 * @State(
 *   id = "custom_state",
 *   label = @Translation("Custom State Manager"),
 *   category = "custom_states"
 * )
 */
class CustomState extends PluginBase implements StateInterface {
  // Due we are implementing StateInterface we need to implement
  // all the methods from the interface.
  // Like get, set, delete, getMultiple, setMultiple,
  // deleteMultiple and resetCache.
  /**
   * The state manager.
   *
   * @var \Drupal\vaibhav_state_api\State\StateManager
   */
  protected $manager;

  /**
   * Constructs a CustomState object.
   *
   * @param array $configuration
   *   A configuration array containing plugin instance information.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\vaibhav_state_api\State\StateManager $manager
   *   The state manager service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StateManager $manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->manager = $manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('vaibhav_state_api.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function get($key, $default = NULL) {
    return $this->manager->get($key) ?? $default;
  }

  /**
   * {@inheritdoc}
   */
  public function set($key, $value) {
    $this->manager->set($key, $value);
  }

  /**
   * {@inheritdoc}
   */
  public function delete($key) {
    $this->manager->delete($key);
  }

  /**
   * {@inheritdoc}
   */
  public function getMultiple($keys) {
    $values = [];
    foreach ($keys as $key) {
      $values[$key] = $this->get($key);
    }
    return $values;
  }

  /**
   * {@inheritdoc}
   */
  public function setMultiple(array $values) {
    foreach ($values as $key => $value) {
      $this->set($key, $value);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function deleteMultiple(array $keys) {
    foreach ($keys as $key) {
      $this->delete($key);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function resetCache() {
    // Implement cache reset if needed.
  }

}
