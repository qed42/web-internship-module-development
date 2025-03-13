<?php

namespace Drupal\virag_form_api\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\State\StateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\virag_form_api\Service\CountryService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a user details form.
 */
class UserDetailsForm extends FormBase {
  /**
   * The state API service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;
  /**
   * The country service.
   *
   * @var \Drupal\virag_form_api\Service\CountryService
   */
  protected $countryService;

  /**
   * Constructs a new UserDetailsForm.
   */
  public function __construct(StateInterface $state, CountryService $countryService) {
    $this->state = $state;
    $this->countryService = $countryService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
          $container->get('state'),
          $container->get('virag_form_api.country_service')
      );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'virag_user_details_form';
  }

  /**
   * Builds the form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $countries = [
      '' => 'Select a Country',
      'USA' => 'United States',
      'CAN' => 'Canada',
      'IND' => 'India',
    ];
    // Define state options (based on selected country)
    $states = $this->getStates($form_state->getValue('country'));

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
      '#unique' => TRUE,
    ];

    $form['age'] = [
      '#type' => 'number',
      '#title' => $this->t('Age'),
      '#required' => TRUE,
    ];

    $form['country'] = [
      '#type' => 'select',
      '#title' => 'Select Country',
          // '#options' => $this->countryService->getCountryOptions(),
      '#options' => $countries,
      '#ajax' => [
        'callback' => '::updateStateDropdown',
    // The element to update.
        'wrapper' => 'state-wrapper',
    // Trigger AJAX on change.
        'event' => 'change',
      ],
      '#prefix' => '<div id="country-wrapper">',
      '#suffix' => '</div>',
    ];

    // State Dropdown (initially empty)
    $form['state'] = [
      '#type' => 'select',
      '#title' => 'State',
      '#options' => $states,
      '#required' => TRUE,
    // Wrapper for AJAX update.
      '#prefix' => '<div id="state-wrapper">',
      '#suffix' => '</div>',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * Validates the form data.
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $email = $form_state->getValue('email');

    // Basic email format check.
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email', $this->t('Please enter a valid email address.'));
      return;
    }

    // Ensure email contains an allowed domain.
    if (!preg_match('/@.+\.(com|org|net|edu)$/', $email)) {
      $form_state->setErrorByName('email', $this->t('Email must have a valid domain like .com, .org, .net, or .edu.'));
      return;
    }

    // Retrieve existing users from State API.
    $users = $this->state->get('virag_form_api.user_data', []);

    // Check if email is already submitted.
    foreach ($users as $user) {
      if ($user['email'] === $email) {
        $form_state->setErrorByName('email', $this->t('This email has already been submitted. Please use a different email address.'));
        return;
      }
    }
  }

  /**
   * Submits the form data.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $email = $form_state->getValue('email');
    $age = $form_state->getValue('age');
    $country = $form_state->getValue('country');
    $state = $form_state->getValue('state');

    // Retrieve existing users.
    $users = $this->state->get('virag_form_api.user_data', []);

    // Store the data in session (temporary).
    // $_SESSION['virag_form_data'][$name] = [
    //     'name' => $name,
    //     'email' => $email,
    //     'age' => $age,
    //   ];.

    // Database insertion
    //     \Drupal::database()->insert('virag_user_data')
    //   ->fields([
    //     'name' => $name,
    //     'email' => $email,
    //     'age' => $age,
    //   ])
    //   ->execute();

    // Store new user data.
    $users[$name] = [
      'name' => $name,
      'email' => $email,
      'age' => $age,
      'country' => $country,
      'state' => $state,
    ];
    $this->state->set('virag_form_api.user_data', $users);

    $this->messenger()->addStatus($this->t('Data saved successfully.'));

    // Redirect to /form/{user} page.
    $response = new RedirectResponse('/form/' . $name);
    $response->send();
  }

  /**
   * AJAX callback: Updates the state dropdown based on selected country.
   */
  public function updateStateDropdown(array &$form, FormStateInterface $form_state) {
    // Only update the 'state' dropdown.
    return $form['state'];
  }

  /**
   * Returns the states based on the selected country.
   */
  private function getStates($country) {
    $states = [
      'USA' => ['NY' => 'New York', 'CA' => 'California', 'TX' => 'Texas'],
      'CAN' => ['ON' => 'Ontario', 'QC' => 'Quebec', 'BC' => 'British Columbia'],
      'IND' => ['MH' => 'Maharashtra', 'DL' => 'Delhi', 'KA' => 'Karnataka'],
    ];

    return $states[$country] ?? ['' => 'Select a State'];
  }

}
