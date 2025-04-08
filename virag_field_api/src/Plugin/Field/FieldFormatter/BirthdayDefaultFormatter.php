<?php

namespace Drupal\virag_field_api\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Plugin implementation of the 'birthday_default' formatter.
 *
 * @FieldFormatter(
 *   id = "birthday_default",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "birthday"
 *   }
 * )
 */
class BirthdayDefaultFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'date_format' => 'medium',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);

    $form['date_format'] = [
      '#type' => 'select',
      '#title' => $this->t('Date format'),
      '#options' => [
        'short' => $this->t('Short'),
        'medium' => $this->t('Medium'),
        'long' => $this->t('Long'),
        'custom' => $this->t('Custom'),
      ],
      '#default_value' => $this->getSetting('date_format'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $date_format = $this->getSetting('date_format');

    $summary[] = $this->t('Date format: @format', ['@format' => $date_format]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $format = $this->getSetting('date_format');
    $display_age = $this->getFieldSetting('display_age');

    foreach ($items as $delta => $item) {
      if (!empty($item->value)) {
        try {
          $date = new DrupalDateTime($item->value);
          $formatted_date = \Drupal::service('date.formatter')->format($date->getTimestamp(), $format);

          $display_text = $formatted_date;

          // Calculate and display age if setting is enabled.
          if ($display_age) {
            $now = new DrupalDateTime();
            $diff = $now->diff($date);
            $age = $diff->y;
            $display_text .= ' (' . $this->t('@age years old', ['@age' => $age]) . ')';
          }

          $elements[$delta] = [
            '#markup' => $display_text,
          ];
        }
        catch (\Exception $e) {
          // Handle invalid date.
          $elements[$delta] = [
            '#markup' => $this->t('Invalid date'),
          ];
        }
      }
    }

    return $elements;
  }

}
