<?php

declare(strict_types=1);

namespace Drupal\vaibhav_config_entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining a config profile entity type.
 */
interface ConfigProfileInterface extends ConfigEntityInterface {

  /**
   * {@inheritdoc}
   */
  public function getCode();

  /**
   * {@inheritdoc}
   */
  public function setCode($code);

}
