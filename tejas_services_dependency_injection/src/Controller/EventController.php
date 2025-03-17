<?php

namespace Drupal\tejas_services_dependency_injection\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\tejas_services_dependency_injection\Service\EventService;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller to display events fetched via the EventService.
 */
class EventController extends ControllerBase {

  /**
   * The event service.
   *
   * @var \Drupal\tejas_services_dependency_injection\Service\EventService
   */
  protected EventService $eventService;

  /**
   * Constructs the EventController.
   *
   * @param \Drupal\tejas_services_dependency_injection\Service\EventService $event_service
   *   The event service.
   */
  public function __construct(EventService $event_service) {
    $this->eventService = $event_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tejas_services_dependency_injection.event_service')
    );
  }

  /**
   * Displays the list of events directly as an HTML response.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   A response containing HTML content.
   */
  public function build(): Response {
    $events = $this->eventService->getEvents();
    $html = "<h1>Event Listings</h1><div class='events-container'>";

    foreach ($events as $event) {
      $html .= "<div class='event-card'>";
      $html .= "<h2>{$event['name']}</h2>";
      $html .= "<p><strong>Date:</strong> {$event['datetime']}</p>";
      $html .= "<p>{$event['description']}</p>";
      $html .= "</div>";
    }

    $html .= "</div>";

    return new Response($html);
  }

}
