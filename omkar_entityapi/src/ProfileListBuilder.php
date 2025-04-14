<?php

declare(strict_types=1);

namespace Drupal\omkar_entityapi;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Provides a list controller for the profile entity type.
 */
final class ProfileListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['id'] = $this->t('ID');
    $header['label'] = $this->t('Label');
    $header['status'] = $this->t('Status');
    $header['uid'] = $this->t('Author');
    $header['created'] = $this->t('Created');
    $header['changed'] = $this->t('Updated');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\omkar_entityapi\ProfileInterface $entity */
    $row['id'] = $entity->id();
    $row['label'] = $entity->toLink();
    $row['status'] = $entity->get('status')->value ? $this->t('Enabled') : $this->t('Disabled');
  
    // Check if UID entity exists before calling isAuthenticated().
    $user_entity = $entity->get('uid')->entity;
    $link_setting = FALSE;
    if ($user_entity !== NULL && $user_entity->isAuthenticated()) {
      $link_setting = TRUE;
    }
  
    $username_options = [
      'label' => 'hidden',
      'settings' => ['link' => $link_setting],
    ];
    $row['uid']['data'] = $entity->get('uid')->view($username_options);
  
    $row['created']['data'] = $entity->get('created')->view(['label' => 'hidden']);
    $row['changed']['data'] = $entity->get('changed')->view(['label' => 'hidden']);
  
    return $row + parent::buildRow($entity);
  }
  
}
