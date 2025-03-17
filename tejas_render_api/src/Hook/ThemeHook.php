<?php

namespace Drupal\tejas_render_api\Hook;

use Drupal\hook_event_dispatcher\Annotation\Hook;

/**
 * Defines theme hooks for the module.
 */
class ThemeHook {

  /**
   * Registers the theme hook.
   *
   * @Hook("theme")
   */
  #[Hook("theme")]
  public function registerTheme() {
    return [
      'event_cards' => [
        'variables' => ['events' => []],
      ],
    ];
  }

}
