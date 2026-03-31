<?php

declare(strict_types=1);

namespace Drupal\nsb_form_examples\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides system behavior settings form.
 */
class FormExamplesSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['nsb_form_examples.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'nsb_form_examples_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('nsb_form_examples.settings');

    $form['maintenance_message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Maintenance message'),
      '#default_value' => $config->get('maintenance_message') ?? '',
      '#description' => $this->t('Message shown during maintenance mode.'),
    ];

    $form['log_level'] = [
      '#type' => 'select',
      '#title' => $this->t('Log level'),
      '#options' => [
        'error' => $this->t('Error'),
        'warning' => $this->t('Warning'),
        'info' => $this->t('Info'),
        'debug' => $this->t('Debug'),
      ],
      '#default_value' => $config->get('log_level') ?? 'error',
    ];

    $form['api_endpoint'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API endpoint URL'),
      '#default_value' => $config->get('api_endpoint') ?? '',
    ];

    $form['request_timeout'] = [
      '#type' => 'number',
      '#title' => $this->t('Request timeout (seconds)'),
      '#min' => 1,
      '#max' => 60,
      '#default_value' => $config->get('request_timeout') ?? 10,
    ];

    $form['debug_mode'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable debug mode'),
      '#default_value' => $config->get('debug_mode') ?? FALSE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $message = trim((string) $form_state->getValue('maintenance_message'));
    $api = $form_state->getValue('api_endpoint');
    $timeout = (int) $form_state->getValue('request_timeout');

    if ($message === '') {
      $form_state->setErrorByName('maintenance_message', $this->t('Maintenance message cannot be empty.'));
    }

    if (!filter_var($api, FILTER_VALIDATE_URL)) {
      $form_state->setErrorByName('api_endpoint', $this->t('Please enter a valid URL.'));
    }

    if ($timeout < 1 || $timeout > 60) {
      $form_state->setErrorByName('request_timeout', $this->t('Timeout must be between 1 and 60 seconds.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('nsb_form_examples.settings')
      ->set('maintenance_message', $form_state->getValue('maintenance_message'))
      ->set('log_level', $form_state->getValue('log_level'))
      ->set('api_endpoint', $form_state->getValue('api_endpoint'))
      ->set('request_timeout', (int) $form_state->getValue('request_timeout'))
      ->set('debug_mode', $form_state->getValue('debug_mode'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
