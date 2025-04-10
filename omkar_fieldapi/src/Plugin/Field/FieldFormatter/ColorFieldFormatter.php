<?php

declare(strict_types=1);

namespace Drupal\omkar_fieldapi\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 *
 */
#[FieldFormatter(
  id: "color_rgb_formatter",
  label: new TranslatableMarkup("Color RGB Formatter"),
  field_types: ["color_rgb"]
)]
class ColorFieldFormatter extends FormatterBase {

  /**
   *
   */
  public function viewElements(FieldItemListInterface $items, $langcode): array {
    $elements = [];

    foreach ($items as $delta => $item) {
      $color = sprintf("#%02x%02x%02x", $item->red, $item->green, $item->blue);

      // Return the color value as plain markup or use a custom render array.
      $elements[$delta] = [
        '#markup' => $color,
      ];
    }

    return $elements;
  }

}
