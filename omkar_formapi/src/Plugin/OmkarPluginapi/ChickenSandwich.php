<?php

declare(strict_types=1);

namespace Drupal\omkar_formapi\Plugin\OmkarPluginapi;

use Drupal\omkar_pluginapi\OmkarPluginapiPluginBase;

/**
 * Provides a Chicken Sandwich plugin.
 *
 * @OmkarPluginapi(
 *   id = "chicken_sandwich",
 *   label = @Translation("Chicken Sandwich"),
 *   description = @Translation("A protein-rich grilled chicken sandwich."),
 *   calories = 450
 * )
 */
class ChickenSandwich extends OmkarPluginapiPluginBase {
  // Inherits all methods: label(), description(), calories().
  // You can override them here if needed.
}
