<?php

declare(strict_types=1);

namespace Drupal\ajinkya_form_api\Hook;

use Drupal\Core\Hook\Attribute\Hook;

/**
 * Hooks related to theming and content output.
 */
class RenderAPItheme {

  /**
   * Implements hook_theme().
   */
  #[Hook('theme')]
  public function theme() : array {
    return [
      'weather_page' => [
        'variables' => [
          'weather_intro' => '',
          'weather_forecast' => '',
          'short_forecast' => '',
          'weather_closures' => '',
        ],
      ],
    ];
  }

}
