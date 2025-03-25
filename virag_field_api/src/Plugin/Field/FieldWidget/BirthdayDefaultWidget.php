<?php

namespace Drupal\virag_field_api\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'birthday_default' widget.
 *
 * @FieldWidget(
 *   id = "birthday_default",
 *   label = @Translation("Birthday date"),
 *   field_types = {
 *     "birthday"
 *   }
 * )
 */
class BirthdayDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $value = $items[$delta]->value ?? '';

    $element['value'] = [
      '#type' => 'date',
      '#title' => $this->t('Birthday'),
      '#default_value' => $value,
      '#date_date_format' => 'Y-m-d',
      '#required' => $this->fieldDefinition->isRequired(),
      '#description' => $this->t('Enter your birthday date.'),
    ];

    return $element;
  }

}
