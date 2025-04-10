<?php

namespace Drupal\omkar_hooks_events\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\GenericEvent;
use Drupal\Core\Entity\EntityInterface;
use Drupal\omkar_hooks_events\Event\BlogPublishedEvent;
use Drupal\Core\Messenger\MessengerInterface;
use Psr\Log\LoggerInterface;
// Use this instead of LoggerInterface.
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Event Subscriber for Omkar Hooks Events module.
 */
class OmkarHooksEventsSubscriber implements EventSubscriberInterface {
  use StringTranslationTrait;

  protected MessengerInterface $messenger;
  protected LoggerInterface $logger;

  /**
   * Constructor with correct logger factory handling.
   */
  public function __construct(MessengerInterface $messenger, LoggerChannelFactoryInterface $loggerFactory) {
    $this->messenger = $messenger;
    // Get module-specific logger.
    $this->logger = $loggerFactory->get('omkar_hooks_events');
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::REQUEST => ['onKernelRequest', 20],
      'entity.insert' => ['onEntityInsert'],
      BlogPublishedEvent::EVENT_NAME => ['onBlogPublished'],
    ];
  }

  /**
   * Respond to HTTP request event.
   */
  public function onKernelRequest(RequestEvent $event) {
    $request = $event->getRequest();
    if (str_contains($request->getRequestUri(), '/blog')) {
      $this->logger->notice('Blog page was accessed.');
    }
  }

  /**
   * Respond to entity insert event.
   */
  public function onEntityInsert(GenericEvent $event) {
    $this->logger->notice('Entity insert event triggered.');

    $entity = $event->getSubject();

    if ($entity instanceof EntityInterface && $entity->getEntityTypeId() === 'node' && $entity->bundle() === 'blog') {
      $this->logger->notice('New blog post created: ' . $entity->label());
    }
  }

  /**
   * Event handler for blog publication.
   */
  public function onBlogPublished(BlogPublishedEvent $event) {
    $node = $event->getNode();
    $title = $node->getTitle();

    // Display message in UI.
    $this->messenger->addMessage($this->t('Blog titled "%title" has been published!', ['%title' => $title]));

    // Log event.
    $this->logger->info('Blog "%title" was published.', ['%title' => $title]);
  }

}
