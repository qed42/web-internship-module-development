<?php

namespace Drupal\weather_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\weather_module\WeatherClientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for weather display.
 */
class WeatherController extends ControllerBase {
  /**
   * Guzzle HTTP client.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  protected $weatherClient;

  /**
   * Intialises the object with the weather client.
   */
  public function __construct(WeatherClientInterface $weatherClient) {
    $this->weatherClient = $weatherClient;
  }

  /**
   * Injects a instance of the WeatherController.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('weather_module.weather_client')
    );
  }

  /**
   * Fetches weather data for a given city.
   */
  public function showWeather() {
    // Default city, can be modified.
    $city = 'London';
    // Replace with a real API key.
    $apiKey = '35095ac571833d0f001b59e3565c0c2a';

    try {
      $data = $this->weatherClient->getWeatherData($city, $apiKey);

      $build = [
        '#type' => 'markup',
        '#markup' => $this->t('<h2>Weather in @city</h2>
          <p><strong>Temperature:</strong> @temp °C</p>
          <p><strong>Humidity:</strong> @humidity%</p>
          <p><strong>Description:</strong> @description</p>', [
            '@city' => $data['name'],
            '@temp' => $data['main']['temp'],
            '@humidity' => $data['main']['humidity'],
            '@description' => $data['weather'][0]['description'],
          ]),
      // Allow safe HTML tags.
        '#allowed_tags' => ['h2', 'p', 'strong'],
      ];

      return $build;
    }
    catch (\Exception $e) {
      return [
        '#type' => 'markup',
        '#markup' => $this->t('Error fetching weather data: @message', ['@message' => $e->getMessage()]),
      ];
    }
  }

}
