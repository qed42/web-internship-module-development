<?php

namespace Drupal\tejas_routes_controllers\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for handling event-related routes.
 */
class EventController extends ControllerBase {

  /**
   * Returns a hardcoded HTML response.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   The HTML response.
   */
  public function build() {
    $html = '
      <h1>Upcoming Events</h1>
      <div class="events-list">
        <div class="event">
          <h2>Drupal Meetup</h2>
          <p><strong>Date:</strong> April 10, 2025</p>
          <p>Join us for an exciting discussion on the latest Drupal features.</p>
        </div>
        <div class="event">
          <h2>React Conference</h2>
          <p><strong>Date:</strong> May 5, 2025</p>
          <p>Explore the future of React.js with industry experts.</p>
        </div>
        <div class="event">
          <h2>Open Source Summit</h2>
          <p><strong>Date:</strong> June 15, 2025</p>
          <p>A deep dive into open-source contributions and collaborations.</p>
        </div>
      </div>
    ';

    return new Response($html);
  }

}
