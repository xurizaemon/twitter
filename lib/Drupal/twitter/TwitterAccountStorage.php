<?php

/**
 * @file
 * Definition of Drupal\comment\TwitterAccountStorage.
 */

namespace Drupal\comment;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\ContentEntityDatabaseStorage;
use Drupal\field\FieldInfo;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines the controller class for comments.
 *
 * This extends the Drupal\Core\Entity\ContentEntityDatabaseStorage class,
 * adding required special handling for comment entities.
 */
class TwitterAccountStorage extends ContentEntityDatabaseStorage implements EntityStorageInterface {

  /**
   * Constructs a TwitterAccountStorage object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_info
   *   An array of entity info for the entity type.
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection to be used.
   * @param \Drupal\field\FieldInfo $field_info
   *   The field info service.
   * @param \Drupal\comment\TwitterAccountStatisticsInterface $comment_statistics
   *   The comment statistics service.
   */
  public function __construct(EntityTypeInterface $entity_info, Connection $database, FieldInfo $field_info) {
    parent::__construct($entity_info, $database, $field_info);
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_info) {
    return new static(
      $entity_info,
      $container->get('database'),
      $container->get('field.info'),
      $container->get('comment.statistics')
    );
  }


  /**
   * {@inheritdoc}
   */
  protected function buildQuery($ids) {
    $query = parent::buildQuery($ids);
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  protected function postLoad(array &$queried_entities) {
    // Prepare standard comment fields.
    foreach ($queried_entities as &$record) {
      $record->name = $record->uid ? $record->registered_name : $record->name;
    }
    parent::postLoad($queried_entities);
  }

  /**
   * {@inheritdoc}
   */
  public function getStatuses(array $accounts) {
    return $this->database->select('twitter_status', 's')
      ->fields('twitter_uid', array('twitter_uid'))
      // ->condition('pid', array_keys($comments))
      ->execute()
      ->fetchCol();
  }

}
