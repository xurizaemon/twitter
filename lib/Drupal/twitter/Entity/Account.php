<?php

/**
 * @file
 * Contains \Drupal\twitter\Entity\Account.php
 */

namespace Drupal\twitter;

namespace Drupal\foo_bar\Entity;
use Drupal\Core\Entity\EntityStorageControllerInterface;
use Drupal\Core\Field\FieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\twitter\AccountInterface;
use Drupal\Core\Entity\ContentEntityInterface;
/* @TODO Unsure about the rest of these. */
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Language\Language;
use Drupal\user\UserInterface;

/**
 * Defines the Twitter account class.
 *
 * @ContentEntityType(
 *   id = "twitter_account",
 *   label = @Translation("Twitter Account"),
 *   controllers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list" = "Drupal\twitter\Entity\Controller\AccountListController",
 *     "access" = "Drupal\Core\Entity\EntityAccessController",
 *     "list_builder" = "Drupal\Core\Entity\EntityListBuilder",
 *     "form" = {
 *       "add" = "Drupal\twitter\Entity\Form\AccountFormController"
 *       "edit" = "Drupal\twitter\Entity\Form\AccountFormController"
 *       "delete" = "Drupal\twitter\Entity\AccountDeleteForm",
 *     },
 *   },
 *   admin_permission = "admin_twitter_accounts",
 *   base_table = "twitter_account",
 *   uri_callback = "twitter_account_uri",
 *   label_callback = "twitter_account_format_name",
 *   fieldable = TRUE,
 *   translatable = FALSE,
 *   entity_keys = {
 *     "id" = "twitter_uid",
 *     "label" = "screen_name",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "edit-form" = "twitter_account.edit",
 *     "admin-form" = "twitter_account.settings",
 *     "delete-form" = "twitter_account.delete"
 *   }
 * )
 */
class Account extends ContentEntityBase implements AccountInterface {

  /**
   * {@inheritdoc}
   */
  public function id() {
    return $this->get('twitter_uid')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getScreenName() {
    return $this->screen_name->value;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['twitter_uid'] = FieldDefinition::create('integer')
      ->setLabel(t('Twitter UID'))
      ->setDescription(t('The Twitter unique account identifier.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['host'] = FieldDefinition::create('string')
      ->setLabel(t('Host'))
      ->setDescription(t('The host for this account.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    $fields['screen_name'] = FieldDefinition::create('string')
      ->setLabel(t('Screen Name'))
      ->setDescription(t('The Twitter account screen name.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    // @TODO should not be displayable eg in views.
    $fields['oauth_token'] = FieldDefinition::create('string')
      ->setLabel(t('OAuth Token'))
      ->setDescription(t('The OAuth token.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    // @TODO should not be displayable eg in views.
    $fields['oauth_token_secret'] = FieldDefinition::create('string')
      ->setLabel(t('OAuth Token Secret'))
      ->setDescription(t('The OAuth token secret.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    $fields['name'] = FieldDefinition::create('string')
      ->setLabel(t('Full Name'))
      ->setDescription(t('The full name of the account user.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    $fields['description'] = FieldDefinition::create('string')
      ->setLabel(t('Twitter Bio'))
      ->setDescription(t('The description/bio associated with the account.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    $fields['location'] = FieldDefinition::create('string')
      ->setLabel(t('Location'))
      ->setDescription(t('The location of the account owner.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    $fields['followers_count'] = FieldDefinition::create('integer')
      ->setLabel(t('Followers'))
      ->setDescription(t('The number of users following this account.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['friends_count'] = FieldDefinition::create('integer')
      ->setLabel(t('Following'))
      ->setDescription(t('The number of users this account is following.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['statuses_count'] = FieldDefinition::create('integer')
      ->setLabel(t('Posts'))
      ->setDescription(t('The number of status updates a user has made.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['favourites_count'] = FieldDefinition::create('integer')
      ->setLabel(t('Favourites'))
      ->setDescription(t('The number of statuses a user has marked as a favourite.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['url'] = FieldDefinition::create('string')
      ->setLabel(t('URL'))
      ->setDescription(t('The URL of the Twitter account.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    $fields['profile_image_url'] = FieldDefinition::create('string')
      ->setLabel(t('Location'))
      ->setDescription(t('The profile image URL of the Twitter account.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    // @TODO Boolean really.
    $fields['protected'] = FieldDefinition::create('integer')
      ->setLabel(t('Protected'))
      ->setDescription(t('Protected status of the Twitter account.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['profile_background_color'] = FieldDefinition::create('string')
      ->setLabel(t('Profile Background Color'))
      ->setDescription(t('The profile background color URL of the Twitter account.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    $fields['profile_text_color'] = FieldDefinition::create('string')
      ->setLabel(t('Profile Text Color'))
      ->setDescription(t('The profile text color of the Twitter account.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    $fields['profile_link_color'] = FieldDefinition::create('string')
      ->setLabel(t('Profile Link Color'))
      ->setDescription(t('The profile link color of the Twitter account.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    $fields['profile_sidebar_fill_color'] = FieldDefinition::create('string')
      ->setLabel(t('Profile Sidebar Fill Color'))
      ->setDescription(t('The profile sidebar fill color of the Twitter account.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    $fields['profile_sidebar_border_color'] = FieldDefinition::create('string')
      ->setLabel(t('Profile Sidebar Border Color'))
      ->setDescription(t('The profile sidebar border color of the Twitter account.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    $fields['profile_background_image_url'] = FieldDefinition::create('string')
      ->setLabel(t('Profile Background Image URL'))
      ->setDescription(t('The profile background image URL of the Twitter account.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    // @TODO Boolean really.
    $fields['profile_background_tile'] = FieldDefinition::create('boolean')
      ->setLabel(t('Profile Background Tile'))
      ->setDescription(t('Whether to tile the profile background image.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    // @TODO Boolean really.
    $fields['verified'] = FieldDefinition::create('integer')
      ->setLabel(t('Verified'))
      ->setDescription(t('Indicates whether a user is a Twitter verified user.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['created_at'] = FieldDefinition::create('string')
      ->setLabel(t('Date/time that the account was created'))
      ->setDescription(t('Date and time the account was created.'))
      ->setSettings(array(
          'default_value' => '',
          'max_length' => 255,
        ));

    // @TODO Unixtime really.
    $fields['created_time'] = FieldDefinition::create('timestamp')
      ->setLabel(t('Created time'))
      ->setDescription(t('A duplicate of {twitter_account}.created_at, in timestamp format.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['utc_offset'] = FieldDefinition::create('integer')
      ->setLabel(t('UTC Offset'))
      ->setDescription(t('The account timezone stored as UTC offset.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['import'] = FieldDefinition::create('boolean')
      ->setLabel(t('Import Statuses'))
      ->setDescription(t("Boolean flag indicating whether the account's statuses should be pulled in by the site."))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['mentions'] = FieldDefinition::create('integer')
      ->setLabel(t('Import Mentions'))
      ->setDescription(t("Boolean flag indicating whether the account's mentions should be pulled in by the site."))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['last_refresh'] = FieldDefinition::create('timestamp')
      ->setLabel(t('UTC Offset'))
      ->setDescription(t('The account timezone stored as UTC offset.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['is_global'] = FieldDefinition::create('integer')
      ->setLabel(t('UTC Offset'))
      ->setDescription(t('Boolean indicating whether this account is available for global use.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['uid'] = FieldDefinition::create('integer')
      ->setLabel(t('Twitter account user ID'))
      ->setDescription(t('The uid of the Drupal user associated with this Twitter account.'))
      ->setSettings(array('target_type' => 'user'))
      ->setQueryable(FALSE);


    return $fields;
  }

}
