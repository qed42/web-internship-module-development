<?php

namespace Drupal\weather_module;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Weather retrieval API client.
 */
class WeatherClient implements WeatherClientInterface {
  /**
   * Guzzle HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $client;

  public function __construct(Client $client) {
    $this->client = $client;
  }

  /**
   * Fetches weather data for a given city.
   */
  public function getWeatherData(string $city, string $apiKey): array {
    $url = "https://api.weatherapi.com/v1/current.json?key=$apiKey&q=$city&aqi=no";
    try {
      $response = $this->client->request('GET', $url);
      return json_decode($response->getBody(), TRUE);
    }
    catch (GuzzleException $e) {
      throw new \Exception('Error fetching weather data: ' . $e->getMessage());
    }
  }

}
