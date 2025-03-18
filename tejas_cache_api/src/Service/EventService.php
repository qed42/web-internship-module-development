<?php

namespace Drupal\tejas_cache_api\Service;

use GuzzleHttp\ClientInterface;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Cache\CacheBackendInterface;

/**
 * Service to fetch and cache event data from an external API.
 */
class EventService {

  /**
   * The HTTP client for making requests.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected ClientInterface $httpClient;

  /**
   * The cache backend interface.
   *
   * @var \Drupal\Core\Cache\CacheBackendInterface
   */
  protected CacheBackendInterface $cache;

  /**
   * Constructs the EventService.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client service.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache
   *   The cache backend service.
   */
  public function __construct(ClientInterface $http_client, CacheBackendInterface $cache) {
    $this->httpClient = $http_client;
    $this->cache = $cache;
  }

  /**
   * Fetches events from an external API with caching.
   *
   * @return array
   *   The decoded JSON response.
   */
  public function getEvents(): array {
    $cache_id = 'tejas_cache_api:events';
    if ($cache = $this->cache->get($cache_id)) {
      return $cache->data;
    }

    try {
      $response = $this->httpClient->request('GET', 'https://67d7ea5b9d5e3a10152c8af1.mockapi.io/event');
      $data = Json::decode($response->getBody()->getContents());
      $this->cache->set($cache_id, $data);
      return $data;
    }
    catch (\Exception $e) {
      return ['error' => $e->getMessage()];
    }
  }

}
