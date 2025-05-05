<?php

namespace Drupal\vaibhav_state_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\State\StateInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Controller for the State API demo.
 */
class StateDemoController extends ControllerBase {

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $customState;

  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructor for StateDemoController.
   *
   * @param \Drupal\Core\State\StateInterface $custom_state
   *   The custom state service.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack service.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   */
  public function __construct(StateInterface $custom_state, RequestStack $request_stack, MessengerInterface $messenger) {
    $this->customState = $custom_state;
    $this->requestStack = $request_stack;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('state'),
      $container->get('request_stack'),
      $container->get('messenger')
    );
  }

  /**
   * Demo page.
   */
  public function demoPage() {
    // Get the current request.
    $request = $this->requestStack->getCurrentRequest();
    $delete = $request->query->get('delete') === 'true';

    // Get current value first (shows persistence between requests)
    $current_value = $this->customState->get('vaibhav_demo_key');

    if ($delete) {
      // If delete parameter is set, delete the value.
      $this->customState->delete('vaibhav_demo_key');
      $this->messenger->addStatus($this->t('Value has been deleted!'));
      $after_action = 'Value was deleted';
    }
    else {
      // Otherwise, set a new value.
      $new_value = date('Y-m-d H:i:s');
      $this->customState->set('vaibhav_demo_key', $new_value);
      $after_action = 'Value was set to: ' . $new_value;
    }

    // Get the value after our action.
    $final_value = $this->customState->get('vaibhav_demo_key');

    $response_data = [
      'current_value' => $current_value ?? 'No value',
      'after_action' => $after_action,
      'final_value' => $final_value ?? 'No value',
    ];

    if ($request->isXmlHttpRequest()) {
      $response = new AjaxResponse();
      $response->addCommand(new HtmlCommand('.value-at-page-load', 'Value at page load: ' . $response_data['current_value']));
      $response->addCommand(new HtmlCommand('.action-performed', 'Action performed: ' . $response_data['after_action']));
      $response->addCommand(new HtmlCommand('.value-after-action', 'Value after action: ' . $response_data['final_value']));
      return $response;
    }

    $build = [
      '#type' => 'markup',
      '#markup' => $this->t('
        <h2>State API Demo</h2>
        <p class="value-at-page-load">Value at page load: @current</p>
        <p class="action-performed">Action performed: @action</p>
        <p class="value-after-action">Value after action: @final</p>
        <p><a href="/admin/states" class="use-ajax">Set new value</a> | <a href="/admin/states?delete=true" class="use-ajax">Delete value</a></p>
      ', [
        '@current' => $current_value ?? 'No value',
        '@action' => $after_action,
        '@final' => $final_value ?? 'No value',
      ]),
      '#attached' => [
        'library' => [
          'core/drupal.ajax',
          'vaibhav_state_api/demo',
        ],
      ],
    ];

    return $build;
  }

}
