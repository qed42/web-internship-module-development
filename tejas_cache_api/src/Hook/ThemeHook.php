<?php

namespace Drupal\tejas_cache_api\Hook;

use Drupal\Core\Hook\Attribute\Hook;

/**
 * Hooks related to theming and content output.
 */
class ThemeHook {

  /**
   * Implements hook_theme().
   *
   * @return array
   *   The theme hook definitions.
   */
  #[Hook('theme')]
  public function theme(): array {
    return [
      'event_card' => [
        'variables' => [
          'name' => '',
          'datetime' => '',
          'description' => '',
        ],
      ],
    ];
  }

}
