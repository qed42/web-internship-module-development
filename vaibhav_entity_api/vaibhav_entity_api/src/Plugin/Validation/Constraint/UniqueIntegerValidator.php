<?php

namespace Drupal\vaibhav_entity_api\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validates the UniqueInteger constraint.
 */
class UniqueIntegerValidator extends ConstraintValidator {

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
    // Ensure $value is extracted correctly if it's a FieldItemList.
    // if ($value instanceof FieldItemListInterface) {
    // Extract actual value.
    // $value = $value->value;
    // }.
    // Validate that it's a pure integer.
    // Convert to string before checking.
    // if (!ctype_digit((string) $value)) {
    // $this->context->addViolation($constraint->notinteger, ['{{ value }}' => $value]);
    // }.
  }

}
