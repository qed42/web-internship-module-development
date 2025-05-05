<?php

namespace Drupal\virag_event_api\EventDispatcher;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Drupal\virag_event_api\Event\ButtonClickEvent;

/**
 * Dispatches the ButtonClickEvent.
 */
class ButtonClickEventDispatcher {

  protected $eventDispatcher;

  public function __construct(EventDispatcherInterface $event_dispatcher) {
    $this->eventDispatcher = $event_dispatcher;
  }

  /**
   *
   */
  public function dispatchButtonClickEvent($message) {
    $event = new ButtonClickEvent($message);
    $this->eventDispatcher->dispatch($event, ButtonClickEvent::EVENT_NAME);
  }

}
