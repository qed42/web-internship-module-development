<?php

namespace Drupal\virag_event_api\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for rendering a button.
 */
class ButtonController extends ControllerBase {

  /**
   * The button click dispatcher service.
   */
  protected $buttonClickDispatcher;

  public function __construct($button_click_dispatcher) {
    $this->buttonClickDispatcher = $button_click_dispatcher;
  }

  /**
   *
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('virag_event_api.button_click_dispatcher')
    );
  }

  /**
   * Renders a button that dispatches an event on click.
   */
  public function renderButton() {
    // Dispatch the event when this route is accessed.
    $this->buttonClickDispatcher->dispatchButtonClickEvent('Button was Rendered!');

    return new Response('<button onclick="alert(\'Event dispatched!\')">Click Me</button>');
  }

}
