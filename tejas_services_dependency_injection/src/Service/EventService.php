<?php

namespace Drupal\tejas_services_dependency_injection\Service;

use GuzzleHttp\ClientInterface;
use Drupal\Component\Serialization\Json;

/**
 * Service to fetch event data from an external API.
 */
class EventService {

  /**
   * The HTTP client for making requests.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected ClientInterface $httpClient;

  /**
   * Constructs the EventService.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client service.
   */
  public function __construct(ClientInterface $http_client) {
    $this->httpClient = $http_client;
  }

  /**
   * Fetches events from an external API.
   *
   * @return array
   *   The decoded JSON response.
   */
  public function getEvents(): array {
    try {
      $response = $this->httpClient->request('GET', 'https://67d7ea5b9d5e3a10152c8af1.mockapi.io/event');
      return Json::decode($response->getBody()->getContents());
    }
    catch (\Exception $e) {
      return ['error' => $e->getMessage()];
    }
  }

}
