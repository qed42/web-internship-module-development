<?php

declare(strict_types=1);

namespace Drupal\omkar_pluginapi\Plugin\OmkarPluginapi;

use Drupal\omkar_pluginapi\OmkarPluginapiPluginBase;

/**
 * @OmkarPluginapi(
 *   id = "sample_Sandwich",
 *   label = @Translation("Sample Sandwich"),
 *   description = @Translation("A tasty sample sandwich."),
 *   calories = 350
 * )
 */
class SampleSandwich extends OmkarPluginapiPluginBase {

}
