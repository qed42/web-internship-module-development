<?php

namespace Drupal\tejas_cache_api\Controller;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Controller\ControllerBase;
use Drupal\tejas_cache_api\Service\EventService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for rendering cached events.
 */
class EventController extends ControllerBase {

  /**
   * The event service.
   *
   * @var \Drupal\tejas_cache_api\Service\EventService
   */
  protected EventService $eventService;

  /**
   * Constructs an EventController object.
   *
   * @param \Drupal\tejas_cache_api\Service\EventService $eventService
   *   The event service.
   */
  public function __construct(EventService $eventService) {
    $this->eventService = $eventService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tejas_cache_api.event_service')
    );
  }

  /**
   * Builds a render array for cached events with cacheability metadata.
   *
   * @return array
   *   A render array.
   */
  public function build() {
    $events = $this->eventService->getEvents();
    $renderedEvents = [];

    foreach ($events as $event) {
      $renderedEvents[] = [
        '#theme' => 'event_card',
        '#name' => $event['name'],
        '#datetime' => $event['datetime'],
        '#description' => $event['description'],
      ];
    }

    $render_array = [
      '#markup' => '<h1>Cached Events</h1>',
      'events' => $renderedEvents,
      '#cache' => [
        'contexts' => ['url'],
      ],
    ];

    return $render_array;
  }

}
