<?php

namespace Drupal\vaibhav_render_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\Client;

/**
 * Controller for weather data.
 */
class WeatherController extends ControllerBase {

  /**
   * The HTTP client for making requests.
   *
   * @var \GuzzleHttp\Client
   */
  protected Client $httpClient;

  /**
   * Constructs a WeatherController object.
   *
   * @param \GuzzleHttp\Client $httpClient
   *   The HTTP client service.
   */
  public function __construct(Client $httpClient) {
    $this->httpClient = $httpClient;
  }

  /**
   * {@inheritdoc}
   *
   * Creates an instance of the WeatherController.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The service container.
   *
   * @return static
   *   Returns an instance of the WeatherController.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('http_client')
    );
  }

  /**
   * Fetches weather data.
   *
   * @return array
   *   A render array containing weather data.
   */
  public function weatherData() {
    $latitude = 18.5204;
    $longitude = 73.8567;
    $url = "https://api.open-meteo.com/v1/forecast?latitude={$latitude}&longitude={$longitude}&current_weather=true";

    try {
      $response = $this->httpClient->get($url);
      $data = json_decode($response->getBody()->getContents(), TRUE);

      if (isset($data['current_weather'])) {
        $weather = [
          'Temperature' => $data['current_weather']['temperature'] . ' °C',
          'Wind Speed' => $data['current_weather']['windspeed'] . ' km/h',
          // 'Weather Code' => $data['current_weather']['weathercode'],
        ];
      }
      else {
        $weather = ['Error' => 'Unable to fetch weather data.'];
      }
    }
    catch (\Exception $e) {
      $weather = ['Error' => 'API request failed: ' . $e->getMessage()];
    }

    return [
      '#theme' => 'vaibhav_weather',
      '#weather' => $weather,
      '#title' => 'Current Weather in Pune',
    ];
  }

}
