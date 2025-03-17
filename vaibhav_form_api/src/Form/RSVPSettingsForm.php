<?php

namespace Drupal\vaibhav_form_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configuration form for RSVP List module.
 */
class RSVPSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['vaibhav_form_api.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'vaibhav_form_api_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('vaibhav_form_api.settings');

    $form['rsvp_enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable RSVP functionality'),
      '#description' => $this->t('Check this box to enable the RSVP functionality site-wide.'),
      '#default_value' => $config->get('rsvp_enabled') ?: FALSE,
    ];

    $form['rsvp_display_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('RSVP display message'),
      '#description' => $this->t('Message to display on RSVP forms.'),
      '#default_value' => $config->get('rsvp_display_message') ?: 'Please provide your email to RSVP for this event.',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('vaibhav_form_api.settings')
      ->set('rsvp_enabled', $form_state->getValue('rsvp_enabled'))
      ->set('rsvp_display_message', $form_state->getValue('rsvp_display_message'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
