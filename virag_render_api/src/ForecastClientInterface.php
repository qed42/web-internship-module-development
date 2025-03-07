<?php 

declare(strict_types=1);

namespace Drupal\anytown;

/**
 * Forecast retrieval API client.
 */
interface ForecastClientInterface {

  /**
   * Get the current forecast.
   *
   * @param string $url
   *   URL to use to retrieve forecast data.
   *
   * @return array|null
   *   An array containing the formatted data for the forecast, or null.
   */
  public function getForecastData(string $url): ?array;

}