<?php

namespace Drupal\vaibhav_form_api\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Component\Datetime\Time;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Component\Utility\EmailValidatorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * A form to collect email addresses for RSVPs.
 */
class RSVPForm extends FormBase {

  /**
   * The route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * The email validator.
   *
   * @var \Drupal\Component\Utility\EmailValidatorInterface
   */
  protected $emailValidator;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The time service.
   *
   * @var \Drupal\Core\Datetime\TimeInterface
   */
  protected $time;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs an RSVPForm object.
   */
  public function __construct(
    RouteMatchInterface $route_match,
    EmailValidatorInterface $email_validator,
    Connection $database,
    Time $time,
    AccountProxyInterface $current_user,
    ConfigFactoryInterface $config_factory,
  ) {
    $this->routeMatch = $route_match;
    $this->emailValidator = $email_validator;
    $this->database = $database;
    $this->time = $time;
    $this->currentUser = $current_user;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_route_match'),
      $container->get('email.validator'),
      $container->get('database'),
      $container->get('datetime.time'),
      $container->get('current_user'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'vaibhav_form_api_email_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $node = $this->routeMatch->getParameter('node');
    $nid = $node ? $node->id() : 0;

    // Get configuration.
    $config = $this->configFactory()->get('vaibhav_form_api.settings');

    // Check if RSVP functionality is enabled at all.
    if (!$config->get('rsvp_enabled')) {
      return [
        '#markup' => $this->t('RSVP functionality is currently disabled.'),
      ];
    }

    $form['message'] = [
      '#type' => 'markup',
      '#markup' => '<p>' . $config->get('rsvp_display_message') . '</p>',
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email Address'),
      '#size' => 25,
      '#description' => $this->t("We'll send updates to the email address you provide."),
      '#required' => TRUE,
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('RSVP'),
      '#ajax' => [
        'callback' => '::ajaxSubmit',
        'wrapper' => 'rsvp-form-wrapper',
        'effect' => 'fade',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Processing submission...'),
        ],
      ],
    ];

    // Store the node ID as a hidden value.
    $form['nid'] = [
      '#type' => 'hidden',
      '#value' => $nid,
    ];

    $form['#prefix'] = '<div id="rsvp-form-wrapper">';
    $form['#suffix'] = '</div>';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $value = $form_state->getValue('email');
    if (!$this->emailValidator->isValid($value)) {
      $form_state->setErrorByName('email', $this->t('The email address %mail is not valid.', ['%mail' => $value]));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function ajaxSubmit(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    if ($form_state->hasAnyErrors()) {
      // Show error messages dynamically.
      $response->addCommand(new MessageCommand($this->t('There were errors in the form. Please fix them and try again.'), NULL, ['type' => 'error']));
      return $response;
    }

    try {
      $this->database->insert('rsvplist')
        ->fields([
          'mail' => $form_state->getValue('email'),
          'nid' => $form_state->getValue('nid'),
          'uid' => $this->currentUser->id(),
          'created' => $this->time->getRequestTime(),
        ])
        ->execute();

      // Replace form with thank you message.
      $response->addCommand(new ReplaceCommand('#rsvp-form-wrapper', '<div class="rsvp-thank-you">' . $this->t('Thank you for your RSVP!') . '</div>'));

      $response->addCommand(new InvokeCommand(NULL, 'scrollTo', [0, 'window.scrollY']));
    }
    catch (\Exception $e) {
      $response->addCommand(new MessageCommand($this->t('Error saving RSVP. Try again later.'), NULL, ['type' => 'error']));
    }

    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Leave this empty since AJAX submission is handled separately.
  }

}
