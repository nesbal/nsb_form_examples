<?php

declare(strict_types=1);

namespace Drupal\nsb_form_examples\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a workshop registration form with AJAX behaviors.
 */
class WorkshopRegistrationForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'nsb_workshop_registration_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['layout'] = [
      '#type' => 'container',
      '#attributes' => [
        'style' => 'display: flex; gap: 40px; align-items: flex-start;',
      ],
    ];

    $form['layout']['left'] = [
      '#type' => 'container',
      '#attributes' => ['style' => 'flex: 1;'],
    ];

    $form['layout']['right'] = [
      '#type' => 'container',
      '#attributes' => ['style' => 'flex: 1;'],
    ];

    $form['layout']['left']['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your name'),
      '#required' => TRUE,
      '#ajax' => [
        'callback' => '::updatePreview',
        'wrapper' => 'invitation-preview',
      ],
    ];

    $form['layout']['left']['workshop'] = [
      '#type' => 'select',
      '#title' => $this->t('Workshop'),
      '#options' => [
        'frontend' => 'Frontend',
        'backend' => 'Backend',
      ],
      '#ajax' => [
        'callback' => '::updateSessions',
        'wrapper' => 'session-wrapper',
      ],
    ];

    $selected_workshop = $form_state->getValue('workshop') ?? 'frontend';

    $sessions = [
      'frontend' => [
        'morning' => 'Morning session',
        'afternoon' => 'Afternoon session',
      ],
      'backend' => [
        'api' => 'API session',
        'performance' => 'Performance session',
      ],
    ];

    $form['layout']['left']['session_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'session-wrapper'],
    ];

    $form['layout']['left']['session_wrapper']['session'] = [
      '#type' => 'select',
      '#title' => $this->t('Session'),
      '#options' => $sessions[$selected_workshop],
      '#ajax' => [
        'callback' => '::updatePreview',
        'wrapper' => 'invitation-preview',
      ],
    ];

    $form['layout']['left']['bring_guests'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Bring guests'),
      '#ajax' => [
        'callback' => '::updatePreview',
        'wrapper' => 'invitation-preview',
      ],
    ];

    $form['layout']['left']['guests'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of guests'),
      '#default_value' => 0,
      '#states' => [
        'visible' => [
          ':input[name="bring_guests"]' => ['checked' => TRUE],
        ],
      ],
      '#ajax' => [
        'callback' => '::updatePreview',
        'wrapper' => 'invitation-preview',
      ],
    ];

    $form['layout']['left']['message'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#ajax' => [
        'callback' => '::updatePreview',
        'wrapper' => 'invitation-preview',
      ],
    ];

    $form['layout']['right']['preview'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'invitation-preview'],
    ];

    $form['layout']['right']['preview']['content'] = [
      '#markup' => $this->buildPreview($form_state),
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Register'),
    ];

    return $form;
  }

  /**
   * AJAX callback to update sessions.
   */
  public function updateSessions(array &$form, FormStateInterface $form_state): array {
    $form_state->setRebuild();
    return $form['session_wrapper'];
  }

  /**
   * AJAX callback to update preview.
   */
  public function updatePreview(array &$form, FormStateInterface $form_state): array {
    return $form['preview'];
  }

  /**
   * Builds invitation preview markup.
   */
  protected function buildPreview(FormStateInterface $form_state): string {
    $name = $form_state->getValue('name') ?? '';
    $workshop = $form_state->getValue('workshop') ?? '';
    $session = $form_state->getValue('session') ?? '';
    $guests = (int) $form_state->getValue('guests');
    $message = $form_state->getValue('message') ?? '';

    return "<div>
      <strong>Invitation Preview</strong><br>
      Name: {$name}<br>
      Workshop: {$workshop}<br>
      Session: {$session}<br>
      Guests: {$guests}<br>
      Message: {$message}
    </div>";
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->messenger()->addStatus($this->t('Registration submitted.'));
  }

}
