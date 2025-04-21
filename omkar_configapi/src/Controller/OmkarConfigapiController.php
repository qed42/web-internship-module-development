<?php

namespace Drupal\omkar_configapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;

class OmkarConfigapiController extends ControllerBase {

  protected $configFactory;

  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }

  /*
   *
   **/
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory')
    );
  }

  /*
   *
   *
   **/
  public function displayMessage() {
    $config = $this->configFactory->get('omkar_configapi.settings');
    $message = $config->get('welcome_message');
    return [
      '#markup' => $this->t('Message: @message', ['@message' => $message]),
    ];
  }

}
