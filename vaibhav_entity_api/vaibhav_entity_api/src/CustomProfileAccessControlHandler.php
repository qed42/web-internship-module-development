<?php

namespace Drupal\vaibhav_entity_api;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Session\AccountInterface;

/**
 * Access control handler for the custom profile entity type.
 */
final class CustomProfileAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   *
   * Link the activities to the permissions. checkAccess() method is used.
   * $operation is defined in the routing.yml file.
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    // Check the admin_permission defined in the @ContentEntityType annotation.
    $admin_permission = $entity->getEntityType()->getAdminPermission();

    if ($account->hasPermission($admin_permission)) {
      return AccessResult::allowed();
    }

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view custom_profile');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit custom_profile');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete custom_profile');
    }
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   *
   * Seperate the checkAccess as the entity does not exist yet.
   * Link the activities to the permissions. checkCreateAccess() method is used.
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    // Check the admin_permission defined in the @ContentEntityType annotation.
    if ($account->hasPermission('administer custom_profile')) {
      return AccessResult::allowed();
    }
    return AccessResult::allowedIfHasPermission($account, 'add custom_profile');
  }

}
