<?php

namespace Drupal\tejas_block_api\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello World' block.
 *
 * @Block(
 *   id = "tejas_hello_world_block",
 *   admin_label = @Translation("Hello World Block"),
 * )
 */
class HelloWorldBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t('Hello, World!'),
    ];
  }

}
