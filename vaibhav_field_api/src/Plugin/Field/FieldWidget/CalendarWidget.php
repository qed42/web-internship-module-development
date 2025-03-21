<?php

namespace Drupal\vaibhav_field_api\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'calendar_widget' widget.
 *
 * @FieldWidget(
 *   id = "calendar_widget",
 *   label = @Translation("Calendar Picker"),
 *   field_types = {"calendar_field"}
 * )
 */
class CalendarWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element['value'] = $element + [
      '#type' => 'date',
      '#default_value' => $items[$delta]->value ?? '',
      '#description' => $this->t('Select a date'),
      '#attributes' => [
        'class' => ['custom-calendar-picker'],
      ],
    ];

    return $element;
  }

}
