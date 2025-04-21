<?php

namespace Drupal\omkar_configapi\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class OmkarConfigapiSettingsForm extends ConfigFormBase {

  protected function getEditableConfigNames() {
    return ['omkar_configapi.settings'];
  }

  public function getFormId() {
    return 'omkar_configapi_settings_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('omkar_configapi.settings');

    $form['welcome_message'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Welcome Message'),
      '#default_value' => $config->get('welcome_message'),
      '#description' => $this->t('Enter the welcome message to be displayed.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('omkar_configapi.settings')
      ->set('welcome_message', $form_state->getValue('welcome_message'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
