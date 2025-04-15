<?php

namespace Drupal\virag_event_api\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Defines the ButtonClickEvent.
 */
class ButtonClickEvent extends Event {
  const EVENT_NAME = 'virag_event_api.button_click';

  protected $message;

  public function __construct($message) {
    $this->message = $message;
  }

  /**
   *
   */
  public function getMessage() {
    return $this->message;
  }

}
