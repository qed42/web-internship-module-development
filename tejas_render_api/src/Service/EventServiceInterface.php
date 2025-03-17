<?php

namespace Drupal\tejas_render_api\Service;

/**
 * Interface for the Event Service.
 */
interface EventServiceInterface {

  /**
   * Fetches events.
   *
   * @return array
   *   List of events.
   */
  public function getEvents(): array;

}
