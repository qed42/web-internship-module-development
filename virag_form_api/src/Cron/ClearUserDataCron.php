<?php

namespace Drupal\virag_form_api\Cron;

use Drupal\Core\State\StateInterface;

/**
 * Defines the cron job to clear submitted user data.
 */
class ClearUserDataCron {
  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  public function __construct(StateInterface $state) {
    $this->state = $state;
  }

  /**
   * Clears user data every hour.
   */
  public function run() {
    $this->state->delete('virag_form_api.user_data');
    \Drupal::logger('virag_form_api')->info('Cleared user data via cron job.');
  }

}
