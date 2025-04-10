<?php

namespace Drupal\omkar_entityapi\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the UniqueInteger constraint.
 */
class UniqueIntegerConstraintValidator extends ConstraintValidator {

  /**
   * {@inheritdoc}
   */
  public function validate($value, Constraint $constraint) {
    if (empty($value)) {
      return;
    }

    // Check if the value is an integer.
    $value = $value->value;
    if (!is_numeric($value) || intval($value) != $value) {
      $this->context->addViolation($constraint->notinteger, ['%value' => $value]);
    }

  }

}
