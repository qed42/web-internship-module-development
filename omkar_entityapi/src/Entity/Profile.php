<?php

declare(strict_types=1);

namespace Drupal\omkar_entityapi\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\omkar_entityapi\ProfileInterface;
use Drupal\user\EntityOwnerTrait;


final class Profile extends ContentEntityBase implements ProfileInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage): void {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {

    $fields = parent::baseFieldDefinitions($entity_type);
    $fields['label'] = BaseFieldDefinition::create('string')

      ->setLabel(t('Label'))->addConstraint('UniqueInteger')
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Status'))
      ->setDefaultValue(TRUE)
      ->setSetting('on_label', 'Enabled')
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => FALSE,
        ],
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'boolean',
        'label' => 'above',
        'weight' => 0,
        'settings' => [
          'format' => 'enabled-disabled',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Description'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Author'))
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback(self::class . '::getDefaultEntityOwner')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => 15,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setDescription(t('The time that the profile was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the profile was last edited.'));

    return $fields;
  }

}
/**
 * Defines the Omkar Entity API Profile entity.
 *
 * @ConfigEntityType(
 *   id = "omkar_entityapi_profile",
 *   label = @Translation("Omkar Entity API Profile"),
 *   handlers = {
 *     "list_builder" = "Drupal\omkar_entityapi\OmkarEntityApiProfileListBuilder",
 *     "form" = {
 *       "add" = "Drupal\omkar_entityapi\Form\OmkarEntityApiProfileForm",
 *       "edit" = "Drupal\omkar_entityapi\Form\OmkarEntityApiProfileForm",
 *       "delete" = "Drupal\omkar_entityapi\Form\OmkarEntityApiProfileDeleteForm"
 *     }
 *   },
 *   config_prefix = "omkar_entityapi_profile",
 *   admin_permission = "administer omkar_entityapi_profile",
 *   links = {
 *     "collection" = "/admin/structure/omkar-entityapi-profile",
 *     "add-form" = "/admin/structure/omkar-entityapi-profile/add",
 *     "edit-form" = "/admin/structure/omkar-entityapi-profile/{omkar_entityapi_profile}/edit",
 *     "delete-form" = "/admin/structure/omkar-entityapi-profile/{omkar_entityapi_profile}/delete"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   },
 *   config_export = {
 *     "id",
 *     "label"
 *   }
 * )
 */
class OmkarEntityApiProfile extends ConfigEntityBase implements OmkarEntityApiProfileInterface {
  // Your entity class implementation
}
