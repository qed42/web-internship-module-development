<?php

declare(strict_types=1);

namespace Drupal\tejas_state_api\Service;

use Drupal\Core\State\StateInterface;
use GuzzleHttp\ClientInterface;
use Drupal\Component\Serialization\Json;

/**
 * Service to fetch event data with State API optimization.
 */
class EventStateService {

  /**
   * The HTTP client for making requests.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected ClientInterface $httpClient;

  /**
   * The State API service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected StateInterface $state;

  /**
   * Constructs the EventStateService.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client service.
   * @param \Drupal\Core\State\StateInterface $state
   *   The State API service.
   */
  public function __construct(ClientInterface $http_client, StateInterface $state) {
    $this->httpClient = $http_client;
    $this->state = $state;
  }

  /**
   * Fetches events from an external API only if needed.
   *
   * @return array
   *   The decoded JSON response.
   */
  public function getOptimizedEvents(): array {
    $lastFetched = $this->state->get('tejas_state_api.last_fetched', 0);
    $currentTime = time();
    $cacheDuration = 600;

    if ($currentTime - $lastFetched < $cacheDuration) {
      return $this->state->get('tejas_state_api.cached_events', []);
    }

    try {
      $response = $this->httpClient->request('GET', 'https://67d7ea5b9d5e3a10152c8af1.mockapi.io/event');
      $events = Json::decode($response->getBody()->getContents());
      $this->state->set('tejas_state_api.cached_events', $events);
      $this->state->set('tejas_state_api.last_fetched', $currentTime);
      return $events;
    }
    catch (\Exception $e) {
      return ['error' => $e->getMessage()];
    }
  }

}
