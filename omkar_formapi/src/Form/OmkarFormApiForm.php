<?php

namespace Drupal\omkar_formapi\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AjaxResponse;

class OmkarFormApiForm extends ConfigFormBase {

  public function getFormId() {
    return 'omkar_formapi_form';
  }

  protected function getEditableConfigNames() {
    return ['omkar_formapi.settings'];
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {

    /////////////////////////////////
    $schema = \Drupal::database()->schema();
if (!$schema->tableExists('omkar_formapi_data')) {
  \Drupal::messenger()->addError('Table does NOT exist!');
} else {
  \Drupal::messenger()->addStatus('Table exists ✅');
}

    /////////////////////////////////
    $config = $this->config('omkar_formapi.settings');

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#default_value' => $config->get('name'),
      '#ajax' => [
        'callback' => '::previewCallback',
        'event' => 'keyup',
        'wrapper' => 'preview-wrapper',
      ],
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#default_value' => $config->get('email'),
      '#ajax' => [
        'callback' => '::previewCallback',
        'event' => 'keyup',
        'wrapper' => 'preview-wrapper',
      ],
    ];

    $form['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#default_value' => $config->get('message'),
      '#ajax' => [
        'callback' => '::previewCallback',
        'event' => 'keyup',
        'wrapper' => 'preview-wrapper',
      ],
    ];

    $form['preview'] = [
      '#type' => 'markup',
      '#markup' => '<div id="preview-wrapper">' . $this->renderPreview($form_state) . '</div>',
    ];

    return parent::buildForm($form, $form_state);
  }

  public function previewCallback(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $preview = $this->renderPreview($form_state);
    $response->addCommand(new HtmlCommand('#preview-wrapper', $preview));
    return $response;
  }

  private function renderPreview(FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $email = $form_state->getValue('email');
    $message = $form_state->getValue('message');

    return '<div><h4>Live Preview:</h4><p><strong>Name:</strong> ' . $name . '</p><p><strong>Email:</strong> ' . $email . '</p><p><strong>Message:</strong> ' . $message . '</p></div>';
  }

  // public function submitForm(array &$form, FormStateInterface $form_state) {
  //   $this->config('omkar_formapi.settings')
  //     ->set('name', $form_state->getValue('name'))
  //     ->set('email', $form_state->getValue('email'))
  //     ->set('message', $form_state->getValue('message'))
  //     ->save();

  //   parent::submitForm($form, $form_state);
  // }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save to custom table.
    \Drupal::database()->insert('omkar_formapi_data')
    ->fields([
      'name' => $form_state->getValue('name'),
      'email' => $form_state->getValue('email'),
      'message' => $form_state->getValue('message'),
      'created' => \Drupal::time()->getCurrentTime(),
    ])
    ->execute();
  
  
    // Optionally also save to config.
    $this->config('omkar_formapi.settings')
      ->set('name', $form_state->getValue('name'))
      ->set('email', $form_state->getValue('email'))
      ->set('message', $form_state->getValue('message'))
      ->save();
  
    parent::submitForm($form, $form_state);
  }
  
}
