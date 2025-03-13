<?php

namespace Drupal\virag_form_api\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;

/**
 * Service to fetch country data from an API.
 */
class CountryService {
  /**
   * Class CountryService.
   *
   * This service provides functionalities related to country operations.
   *
   * @package Drupal\virag_form_api\Service
   */
  protected Client $client;

  /**
   * Constructor.
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  /**
   * Fetches country options from an external API.
   */
  public function getCountryOptions(): array {
    $options = ['' => 'Loading countries...'];

    try {
      $response = $this->client->request('GET', 'https://restcountries.com/v3.1/all');
      $countries = json_decode($response->getBody(), TRUE);

      if (!empty($countries)) {
        $options = ['' => 'Select a Country'];
        foreach ($countries as $country) {
          if (!empty($country['name']['common'])) {
            $options[$country['name']['common']] = $country['name']['common'];
          }
        }
        asort($options);
      }
    }
    catch (RequestException $e) {
      // $this->logger->error('Failed to fetch countries: @error', ['@error' => $e->getMessage()]);
    }

    return $options;
  }

}
