<?php

declare(strict_types=1);

namespace Drupal\virag_custom_entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a virag custom entity entity type.
 */
interface ViragCustomEntityInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
