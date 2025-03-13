<?php

declare(strict_types=1);

namespace Drupal\ajinkya_render_api;

use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Forecast retrieval API client.
 */
class ForecastClient implements ForecastClientInterface {

  /**
   * Guzzle HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $httpClient;

  /**
   * Logger channel.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * Construct a forecast API client.
   *
   * @param \GuzzleHttp\ClientInterface $httpClient
   *   Guzzle HTTP client.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $logger_factory
   *   Logger factory service.
   */
  public function __construct(ClientInterface $httpClient, LoggerChannelFactoryInterface $logger_factory) {
    $this->httpClient = $httpClient;
    $this->logger = $logger_factory->get('anytown');
  }

  /**
   * {@inheritDoc}
   */
  public function getForecastData(string $url) : ?array {
    try {
      $response = $this->httpClient->get($url);
      $json = json_decode($response->getBody()->getContents());
    }
    catch (GuzzleException $e) {
      $this->logger->warning($e->getMessage());
      return NULL;
    }

    $forecast = [];
    foreach ($json->list as $day) {
      $forecast[$day->day] = [
        'weekday' => ucfirst($day->day),
        'description' => $day->weather[0]->description,
        'high' => $this->kelvinToFahrenheit($day->main->temp_max),
        'low' => $this->kelvinToFahrenheit($day->main->temp_min),
        'icon' => $day->weather[0]->icon,
      ];
    }

    return $forecast;
  }

  /**
   * Helper to convert temperature values form Kelvin to Fahrenheit.
   *
   * @param float $kelvin
   *   Temperature in Kelvin.
   *
   * @return float
   *   Temperature in Fahrenheit.
   */
  public static function kelvinToFahrenheit(float $kelvin) : float {
    return round(($kelvin - 273.15) * 9 / 5 + 32);
  }

}
