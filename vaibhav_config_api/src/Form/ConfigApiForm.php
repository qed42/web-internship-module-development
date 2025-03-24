<?php

namespace Drupal\vaibhav_config_api\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure settings for the Vaibhav Config API.
 */
class ConfigApiForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['vaibhav_config_api.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'vaibhav_config_api_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('vaibhav_config_api.settings');

    $form['footer_text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Footer Text'),
      '#default_value' => $config->get('footer_text'),
      '#description' => $this->t('Enter the text to be displayed in the footer.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('vaibhav_config_api.settings')
      ->set('footer_text', $form_state->getValue('footer_text'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
