<?php

namespace Drupal\ajinkya_event_subscriber\EventSubscriber;

use Drupal\Core\Messenger\MessengerInterface;
use Drupal\ajinkya_event_subscriber\Event\UserLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Subscribes to user login events.
 */
class UserLoginSubscriber implements EventSubscriberInterface {

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs a new UserLoginSubscriber object.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      UserLoginEvent::EVENT_NAME => ['onUserLogin', 0],
    ];
  }

  /**
   * Handler for the user login event.
   *
   * @param \Drupal\my_events_example\Event\UserLoginEvent $event
   *   The event.
   */
  public function onUserLogin(UserLoginEvent $event) {
    $account = $event->getAccount();
    $this->messenger->addStatus('Welcome, @name! This message is brought to you by the Events Example module.', [
      '@name' => $account->getDisplayName(),
    ]);
  }

}
