<?php

namespace Drupal\tejas_render_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\tejas_render_api\Service\EventServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for rendering events.
 */
class EventController extends ControllerBase {

  /**
   * The event service.
   *
   * @var \Drupal\tejas_render_api\Service\EventServiceInterface
   */
  protected $eventService;

  /**
   * Constructs an EventController object.
   */
  public function __construct(EventServiceInterface $eventService) {
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

    return [
      '#theme' => 'event_cards',
      '#events' => $events,
    ];
  }

}
