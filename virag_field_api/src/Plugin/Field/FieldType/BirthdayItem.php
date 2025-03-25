<?php

namespace Drupal\virag_field_api\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'birthday' field type.
 *
 * @FieldType(
 *   id = "birthday",
 *   label = @Translation("Birthday"),
 *   description = @Translation("Stores a birthday date."),
 *   default_widget = "birthday_default",
 *   default_formatter = "birthday_default"
 * )
 */
class BirthdayItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'value' => [
          'type' => 'varchar',
          'length' => 20,
          'not null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['value'] = DataDefinition::create('string')
      ->setLabel(t('Birthday date'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('value')->getValue();
    return $value === NULL || $value === '';
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    return [
      'display_age' => TRUE,
    ] + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $element = parent::fieldSettingsForm($form, $form_state);

    $element['display_age'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Display age'),
      '#description' => $this->t('Display age along with the birthday date.'),
      '#default_value' => $this->getSetting('display_age'),
    ];

    return $element;
  }

}
