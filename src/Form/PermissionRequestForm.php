<?php

declare(strict_types=1);

namespace Drupal\nsb_form_examples\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a permission request form with role-based validation.
 */
class PermissionRequestForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'nsb_permission_request_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $user = $this->currentUser();
    $roles = $user->getRoles();

    $form['request_type'] = [
      '#type' => 'select',
      '#title' => $this->t('Request type'),
      '#options' => [
        'basic' => $this->t('Basic'),
        'advanced' => $this->t('Advanced'),
      ],
      '#default_value' => 'basic',
    ];

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
    ];

    $form['justification'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Justification'),
    ];

    $form['extra_details'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Extra details'),
      '#states' => [
        'visible' => [
          ':input[name="request_type"]' => ['value' => 'advanced'],
        ],
      ],
    ];

    if (in_array('administrator', $roles, TRUE)) {
      $form['admin_notes'] = [
        '#type' => 'textarea',
        '#title' => $this->t('Admin notes'),
      ];
    }

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $user = $this->currentUser();
    $roles = $user->getRoles();

    $request_type = $form_state->getValue('request_type');
    $justification = trim((string) $form_state->getValue('justification'));
    $extra_details = trim((string) $form_state->getValue('extra_details'));

    if ($user->isAnonymous()) {
      $form_state->setErrorByName('title', $this->t('Anonymous users cannot submit this form.'));
    }

    if (in_array('content_editor', $roles, TRUE) && $justification === '') {
      $form_state->setErrorByName('justification', $this->t('Justification is required for content editors.'));
    }

    if ($request_type === 'advanced' && $extra_details === '') {
      $form_state->setErrorByName('extra_details', $this->t('Extra details are required for advanced requests.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->messenger()->addStatus($this->t('Permission request submitted successfully.'));
  }

}
