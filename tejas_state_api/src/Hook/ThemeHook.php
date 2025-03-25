<?php

declare(strict_types=1);

namespace Drupal\tejas_state_api\Hook;

use Drupal\Core\Hook\Attribute\Hook;

/**
 * Hooks related to theming and content output.
 */
class ThemeHook {

  /**
   * Implements hook_theme().
   */
  #[Hook('theme')]
  public function theme(): array {
    return [
      'event_state_card' => [
        'variables' => [
          'name' => '',
          'datetime' => '',
          'description' => '',
        ],
      ],
    ];
  }

}
