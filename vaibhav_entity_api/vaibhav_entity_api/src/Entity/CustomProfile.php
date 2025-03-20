<?php

declare(strict_types=1);

namespace Drupal\vaibhav_entity_api\Entity;

use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\RevisionableContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\user\EntityOwnerTrait;
use Drupal\vaibhav_entity_api\CustomProfileInterface;

/**
 * Defines the custom profile entity class.
 *
 * Fields which are there in this entity are defined in this file.
 *
 * @ContentEntityType(
 *   id = "custom_profile",
 *   label = @Translation("Custom Profile"),
 *
 *   label_collection = @Translation("Custom Profiles"),
 *   label_singular = @Translation("custom profile"),
 *   label_plural = @Translation("custom profiles"),
 *   label_count = @PluralTranslation(
 *     singular = "@count custom profiles",
 *     plural = "@count custom profiles",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\vaibhav_entity_api\CustomProfileListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\vaibhav_entity_api\CustomProfileAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\vaibhav_entity_api\Form\CustomProfileForm",
 *       "edit" = "Drupal\vaibhav_entity_api\Form\CustomProfileForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *       "delete-multiple-confirm" = "Drupal\Core\Entity\Form\DeleteMultipleForm",
 *       "revision-delete" = \Drupal\Core\Entity\Form\RevisionDeleteForm::class,
 *       "revision-revert" = \Drupal\Core\Entity\Form\RevisionRevertForm::class,
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *       "revision" = \Drupal\Core\Entity\Routing\RevisionHtmlRouteProvider::class,
 *     },
 *   },
 *   base_table = "custom_profile",
 *   data_table = "custom_profile_field_data",
 *   revision_table = "custom_profile_revision",
 *   revision_data_table = "custom_profile_field_revision",
 *   show_revision_ui = TRUE,
 *   translatable = TRUE,
 *   admin_permission = "administer custom_profile",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "revision_id",
 *     "langcode" = "langcode",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_uid",
 *     "revision_created" = "revision_timestamp",
 *     "revision_log_message" = "revision_log",
 *   },
 *   links = {
 *     "collection" = "/admin/content/custom-profile",
 *     "add-form" = "/admin/content/profile/add",
 *     "canonical" = "/admin/content/profile/{custom_profile}",
 *     "edit-form" = "/admin/content/profile/{custom_profile}/edit",
 *     "delete-form" = "/admin/content/profile/{custom_profile}/delete",
 *     "delete-multiple-form" = "/admin/content/custom-profile/delete-multiple",
 *     "revision" = "/admin/content/profile/{custom_profile}/revision/{custom_profile_revision}/view",
 *     "revision-delete-form" = "/admin/content/profile/{custom_profile}/revision/{custom_profile_revision}/delete",
 *     "revision-revert-form" = "/admin/content/profile/{custom_profile}/revision/{custom_profile_revision}/revert",
 *     "version-history" = "/admin/content/profile/{custom_profile}/revisions",
 *   },
 *   field_ui_base_route = "entity.custom_profile.settings",
 * )
 */
final class CustomProfile extends RevisionableContentEntityBase implements CustomProfileInterface {

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
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
      ->setLabel(t('Label'))
      ->setRequired(TRUE)
      // Inbuilt constraint to check for uniqueness.
      ->addConstraint('UniqueField')
      // Custom constraint to check for unique int.
      ->addConstraint('UniqueInteger')
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
      ->setRevisionable(TRUE)
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
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
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
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE)
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
      ->setTranslatable(TRUE)
      ->setDescription(t('The time that the custom profile was created.'))
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
      ->setTranslatable(TRUE)
      ->setDescription(t('The time that the custom profile was last edited.'));

    return $fields;
  }

}
