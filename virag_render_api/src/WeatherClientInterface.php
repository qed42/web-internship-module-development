<?php

namespace Drupal\weather_module;

use GuzzleHttp\Exception\GuzzleException;

/**
 * Weather retrieval API client.
 */
interface WeatherClientInterface {

  /**
   * Fetches weather data for a given city.
   *
   * @param string $city
   *   The name of the city.
   * @param string $apiKey
   *   The API key for OpenWeatherMap.
   *
   * @return array
   *   The weather data.
   *
   * @throws \GuzzleHttp\Exception\GuzzleException
   */
  public function getWeatherData(string $city, string $apiKey): array;

}
