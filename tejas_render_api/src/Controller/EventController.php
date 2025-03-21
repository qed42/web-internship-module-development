<?php

namespace Drupal\tejas_render_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\tejas_render_api\Service\EventService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for rendering events.
 */
class EventController extends ControllerBase {

  /**
   * The event service.
   *
   * @var \Drupal\tejas_render_api\Service\EventService
   */
  protected $eventService;

  /**
   * Constructs an EventController object.
   */
  public function __construct(EventService $eventService) {
    $this->eventService = $eventService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tejas_render_api.event_service')
    );
  }

  /**
   * Builds a render array for events.
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

    return [
      '#markup' => '<h1>Rendered Events</h1>',
      'events' => $renderedEvents,
    ];
  }

}
