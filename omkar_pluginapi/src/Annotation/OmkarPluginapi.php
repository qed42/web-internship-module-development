<?php

declare(strict_types=1);

namespace Drupal\omkar_pluginapi\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines omkar_pluginapi annotation object.
 *
 * @Annotation
 */
final class OmkarPluginapi extends Plugin {

  /**
   * The plugin ID.
   */
  public readonly string $id;

  /**
   * The human-readable name of the plugin.
   *
   * @ingroup plugin_translatable
   */
  public readonly string $title;

  /**
   * The description of the plugin.
   *
   * @ingroup plugin_translatable
   */
  public readonly string $description;

  /**
   * The number of calories per serving of this sandwich type.
   *
   * This property is a float value, so we indicate that to other developers
   * who are writing annotations for a Sandwich plugin.
   *
   * @var int
   */
  public $calories;

}
