<?php

namespace Drupal\omkar_formapi\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Database\Connection;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\omkar_pluginapi\OmkarPluginapiPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class OmkarFormApiForm extends ConfigFormBase {

  protected $pluginManager;
  protected $database;
  protected $messenger;
  protected $dateFormatter;

  public function __construct(
    OmkarPluginapiPluginManager $plugin_manager,
    Connection $database,
    MessengerInterface $messenger,
    DateFormatterInterface $date_formatter
  ) {
    $this->pluginManager = $plugin_manager;
    $this->database = $database;
    $this->messenger = $messenger;
    $this->dateFormatter = $date_formatter;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.omkar_pluginapi'),
      $container->get('database'),
      $container->get('messenger'),
      $container->get('date.formatter')
    );
  }

  public function getFormId() {
    return 'omkar_formapi_form';
  }

  protected function getEditableConfigNames() {
    return ['omkar_formapi.settings'];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $schema = $this->database->schema();
    if (!$schema->tableExists('omkar_formapi_data')) {
      $this->messenger->addError('Table does NOT exist!');
    } else {
      $this->messenger->addStatus('Table exists ✅');
    }

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

    $plugins = $this->pluginManager->getDefinitions();
    $form['plugin_sandwich_list'] = [
      '#type' => 'details',
      '#title' => $this->t('Available Sandwich Plugins 🍔'),
      '#open' => TRUE,
    ];

    foreach ($plugins as $plugin_id => $definition) {
      $form['plugin_sandwich_list'][$plugin_id] = [
        '#type' => 'item',
        '#title' => $definition['label'],
        '#markup' => '<p>' . $definition['description'] . '</p><p><strong>Calories:</strong> ' . $definition['calories'] . '</p>',
      ];
    }

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

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->database->insert('omkar_formapi_data')
      ->fields([
        'name' => $form_state->getValue('name'),
        'email' => $form_state->getValue('email'),
        'message' => $form_state->getValue('message'),
        'created' => time(), // You can use PHP time() or inject Time service separately
      ])
      ->execute();

    $this->config('omkar_formapi.settings')
      ->set('name', $form_state->getValue('name'))
      ->set('email', $form_state->getValue('email'))
      ->set('message', $form_state->getValue('message'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
