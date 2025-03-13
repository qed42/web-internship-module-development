<?php

namespace Drupal\virag_form_api\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\State\StateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller to display submitted user details.
 */
class UserDetailsController extends ControllerBase {

  /**
   * The state API service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * Constructs a new UserDetailsController.
   */
  public function __construct(StateInterface $state) {
    $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('state')
    );
  }

  /**
   * Displays user details.
   */
  public function display($user) {
    // Retrieve data from session (temporary).
    // $data = $_SESSION['virag_form_data'][$user] ?? NULL;.

    // Retrieve stored data from State API.
    $users = $this->state->get('virag_form_api.user_data', []);
    $data = $users[$user] ?? NULL;

    // Dynamically generate the markup using T-function`@`.
    if (!$data) {
      return [
        '#markup' => $this->t('User data not found for @user.', ['@user' => $user]),
      ];
    }

    return [
      '#type' => 'markup',
      '#markup' => $this->t('<h2>User Details</h2>
        <p><strong>Name:</strong> @name</p>
        <p><strong>Email:</strong> @email</p>
        <p><strong>Age:</strong> @age</p>', [
          '@name' => $data['name'],
          '@email' => $data['email'],
          '@age' => $data['age'],
          '@country' => $data['country'],
          '@state' => $data['state'],
        ]),
      '#allowed_tags' => ['h2', 'p', 'strong'],
    ];
  }

}
