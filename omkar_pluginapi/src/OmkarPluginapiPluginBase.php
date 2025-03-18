<?php

declare(strict_types=1);

namespace Drupal\omkar_pluginapi;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for omkar_pluginapi plugins.
 */
abstract class OmkarPluginapiPluginBase extends PluginBase implements OmkarPluginapiInterface {

  /**
   * {@inheritdoc}
   */
  public function label(): string {
    return (string) $this->pluginDefinition['label'];
  }
  
  /**
   * {@inheritdoc}
   */
  public function description()
  {
    return $this->pluginDefinition['description'];
  }

    /**
     * {@inheritdoc}
     */
  public function calories()
  {
    return $this->pluginDefinition['calories'];
    
  }

   /**
   * {@inheritdoc}
   */
  // abstract public function order(array $extras);
}
