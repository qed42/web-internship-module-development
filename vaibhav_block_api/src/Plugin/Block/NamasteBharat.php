<?php

namespace Drupal\vaibhav_block_api\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Namaste Bharat' block.
 *
 * @Block(
 *   id = "namaste_bharat_block",
 *   admin_label = @Translation("Namaste Bharat Block"),
 *   category = @Translation("Vaibhav")
 * )
 */
class NamasteBharat extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t('Namaste, Bharat!'),
    ];
  }

}
