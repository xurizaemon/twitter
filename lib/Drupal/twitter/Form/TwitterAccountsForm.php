<?php
/**
 * @file
 * Contains \Drupal\twitter\Form\TwitterSettingsForm.
 */

namespace Drupal\twitter\Form;

use Drupal\Core\Form\ConfigFormBase;

/**
 * Configure twitter settings for this site.
 */
class TwitterAccountsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'twitter_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state) {
    $twitter_config = $this->configFactory->get('twitter.settings');

    $form['auth_add'] = array(
      '#type' => 'fieldset',
      '#title' => t('Add account with authentication'),
      '#description' => t('Authenticating accounts is required for user login and submitting tweets.'),
    );
    $form['auth_add']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Authenticate account'),
    );

    $form['noauth_add'] = array(
      '#type' => 'fieldset',
      '#title' => t('Add Twitter account without authentication'),
      '#description' => t('Unauthenticated accounts provide read-only access, e.g. for importing a public Twitter account.'),
    );
    $form['noauth_add']['account'] = array(
      '#type' => 'textfield',
      '#title' => t('Account Name'),
      '#description' => t('Enter the Twitter account name.'),
    );
    $form['noauth_add']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Add Account'),
    );

    $form['accounts'] = array(
      '#type' => 'fieldset',
      '#title' => t('Twitter Accounts'),
    );

    $storage = \Drupal::entityManager()->getStorage('twitter_account');
    $x = $storage->load(16539754);
    dpm($x, 'x');
    dpm($storage, 's');

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
    switch ($form_state['triggering_element']) {
      case t('Authenticate account'):
        // Redirect to Twitter OAuth.
        break;

      case t('Add Account'):
        // Add directly to DB.
        break;
    }
    parent::submitForm($form, $form_state);
  }

}
