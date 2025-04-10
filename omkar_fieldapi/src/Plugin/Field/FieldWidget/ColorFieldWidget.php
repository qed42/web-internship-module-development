<?php

declare(strict_types=1);

namespace Drupal\omkar_fieldapi\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\Attribute\FieldWidget;
use Drupal\Core\StringTranslation\TranslatableMarkup;

#[FieldWidget(
  id: "color_rgb_widget",
  label: new TranslatableMarkup("Color RGB Widget"),
  field_types: ["color_rgb"]
)]
class ColorFieldWidget extends WidgetBase {

  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state): array {
    $element['red'] = [
      '#type' => 'number',
      '#title' => $this->t('Red'),
      '#default_value' => $items[$delta]->red ?? 0,
      '#min' => 0,
      '#max' => 255,
    ];
    $element['green'] = [
      '#type' => 'number',
      '#title' => $this->t('Green'),
      '#default_value' => $items[$delta]->green ?? 0,
      '#min' => 0,
      '#max' => 255,
    ];
    $element['blue'] = [
      '#type' => 'number',
      '#title' => $this->t('Blue'),
      '#default_value' => $items[$delta]->blue ?? 0,
      '#min' => 0,
      '#max' => 255,
    ];
    return $element;
  }

}
