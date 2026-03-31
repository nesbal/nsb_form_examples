<?php

declare(strict_types=1);

namespace Drupal\nsb_form_examples\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a support ticket form.
 */
class SupportTicketForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'nsb_support_ticket_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['subject'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Subject'),
    ];

    $form['category'] = [
      '#type' => 'select',
      '#title' => $this->t('Category'),
      '#options' => [
        'bug' => $this->t('Bug'),
        'feature' => $this->t('Feature'),
        'other' => $this->t('Other'),
      ],
    ];

    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
    ];

    $form['priority'] = [
      '#type' => 'select',
      '#title' => $this->t('Priority'),
      '#options' => [
        'low' => $this->t('Low'),
        'medium' => $this->t('Medium'),
        'high' => $this->t('High'),
      ],
    ];

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
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $subject = $form_state->getValue('subject');
    $category = $form_state->getValue('category');
    $description = $form_state->getValue('description');
    $priority = $form_state->getValue('priority');

    $this->messenger()->addStatus($this->t(
      'Ticket submitted: Subject: @subject, Category: @category, Priority: @priority, Description: @description',
      [
        '@subject' => $subject,
        '@category' => $category,
        '@priority' => $priority,
        '@description' => $description,
      ]
    ));
  }

}
