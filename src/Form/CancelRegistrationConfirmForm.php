<?php

declare(strict_types=1);

namespace Drupal\nsb_form_examples\Form;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Provides a confirmation form for canceling workshop registration.
 */
class CancelRegistrationConfirmForm extends ConfirmFormBase {

  /**
   * The username from route.
   */
  protected string $name;

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'nsb_cancel_registration_confirm_form';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion():  TranslatableMarkup {
    return $this->t('Are you sure you want to cancel registration for @name?', [
      '@name' => $this->name,
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl(): Url {
    return Url::fromRoute('nsb_form_examples.workshop_registration');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText(): TranslatableMarkup {
    return $this->t('Cancel registration');
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription(): TranslatableMarkup {
    return $this->t('This action cannot be undone.');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $name = ''): array {
    $this->name = $name;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->messenger()->addStatus($this->t('Registration for @name has been canceled.', [
      '@name' => $this->name,
    ]));

    $form_state->setRedirect('nsb_form_examples.workshop_registration');
  }

}
