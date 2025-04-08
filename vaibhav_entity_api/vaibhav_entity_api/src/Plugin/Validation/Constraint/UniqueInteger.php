<?php

namespace Drupal\vaibhav_entity_api\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Checks that a value is unique integer.
 *
 * @Constraint(
 *   id = "UniqueInteger",
 *   label = @Translation("Unique Integer", context = "Validation")
 * )
 */
class UniqueInteger extends Constraint {
  /**
   * The message that will be shown if the value is not an integer.
   *
   * @var string
   */
  public $notinteger = 'The value %value is not an integer.';

}
