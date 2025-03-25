<?php

namespace Drupal\tejas_state_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\tejas_state_api\Service\EventStateService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for rendering events using State API.
 */
class EventStateController extends ControllerBase {

  /**
   * The event state service.
   *
   * @var \Drupal\tejas_state_api\Service\EventStateService
   */
  protected $eventStateService;

  /**
   * Constructs an EventStateController object.
   */
  public function __construct(EventStateService $eventStateService) {
    $this->eventStateService = $eventStateService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tejas_state_api.event_state_service')
    );
  }

  /**
   * Builds a render array for events.
   */
  public function build() {
    $events = $this->eventStateService->getOptimizedEvents();
    $renderedEvents = [];

    foreach ($events as $event) {
      $renderedEvents[] = [
        '#theme' => 'event_state_card',
        '#name' => $event['name'],
        '#datetime' => $event['datetime'],
        '#description' => $event['description'],
      ];
    }

    return [
      '#markup' => '<h1>State API Optimized Events</h1>',
      'events' => $renderedEvents,
    ];
  }

}
