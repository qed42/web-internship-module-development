<?php

namespace Drupal\omkar_fieldapi\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\Attribute\FieldType;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 *
 */
#[FieldType(
  id: "color_rgb",
  label: new TranslatableMarkup("Color RGB"),
  description: new TranslatableMarkup("Stores a color in RGB format."),
  default_widget: "color_rgb_widget",
  default_formatter: "color_rgb_formatter"
)]
class ColorFieldItem extends FieldItemBase {

  /**
   *
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array {
    $properties['red'] = DataDefinition::create('integer')->setLabel(new TranslatableMarkup('Red value'));
    $properties['green'] = DataDefinition::create('integer')->setLabel(new TranslatableMarkup('Green value'));
    $properties['blue'] = DataDefinition::create('integer')->setLabel(new TranslatableMarkup('Blue value'));
    return $properties;
  }

  /**
   *
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition): array {
    return [
      'columns' => [
        'red' => ['type' => 'int', 'size' => 'tiny', 'unsigned' => TRUE],
        'green' => ['type' => 'int', 'size' => 'tiny', 'unsigned' => TRUE],
        'blue' => ['type' => 'int', 'size' => 'tiny', 'unsigned' => TRUE],
      ],
    ];
  }

  /**
   *
   */
  public function isEmpty(): bool {
    return $this->get('red')->getValue() === NULL &&
           $this->get('green')->getValue() === NULL &&
           $this->get('blue')->getValue() === NULL;
  }

}
