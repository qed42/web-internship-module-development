<?php

declare(strict_types=1);

namespace Drupal\vaibhav_entity_api;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a custom profile entity type.
 */
interface CustomProfileInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
