<?php

namespace Drupal\virag_event_api\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\virag_event_api\Event\ButtonClickEvent;

/**
 * Subscribes to the ButtonClickEvent.
 */
class ButtonClickSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      ButtonClickEvent::EVENT_NAME => ['onButtonRender', 100],
      ButtonClickEvent::EVENT_NAME => ['onButtonClick', 50],
    ];
  }

  /**
   * Handles the button render event.
   */
  public function onButtonRender(ButtonClickEvent $event) {
    \Drupal::logger('virag_event_api')->notice('Custom Event Triggered: ' . $event->getMessage());
  }

}
