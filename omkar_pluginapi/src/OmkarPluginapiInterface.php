<?php

declare(strict_types=1);

namespace Drupal\omkar_pluginapi;

/**
 * Interface for omkar_pluginapi plugins.
 */
interface OmkarPluginapiInterface {

  /**
   * Provide a description of the sandwich.
   *
   * @return string
   *   A string description of the sandwich.
   */
  public function description();

  /**
   * Provide the number of calories per serving for the sandwich.
   *
   * @return float
   *   The number of calories per serving.
   */
  public function calories();

  /**
   * Returns the translated plugin label.
   */
  public function label(): string;

}
