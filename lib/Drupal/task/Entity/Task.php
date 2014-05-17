<?php

/**
 * @file
 * Contains \Drupal\task\Plugin\Core\Entity\Task.
 */

namespace Drupal\task\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\FieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\task\TaskInterface;

/**
 * Defines the task entity class.
 *
 * @ContentEntityType(
 *   id = "task",
 *   label = @Translation("Task"),
 *   bundle_label = @Translation("Task type"),
 *   controllers = {
 *     "access" = "Drupal\task\TaskAccessController",
 *     "form" = {
 *       "add" = "Drupal\task\TaskForm",
 *       "edit" = "Drupal\task\TaskForm",
 *       "default" = "Drupal\task\TaskForm"
 *     }
 *   },
 *   admin_permission = "administer tasks",
 *   base_table = "task",
 *   links = {
 *     "canonical" = "task.edit",
 *     "delete-form" = "task.delete",
 *     "edit-form" = "task.edit",
 *     "admin-form" = "task.type_edit"
 *   },
 *   fieldable = TRUE,
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid"
 *   },
 *   bundle_entity_type = "task_type"
 * )
 */
class Task extends ContentEntityBase implements TaskInterface {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = FieldDefinition::create('integer')
        ->setLabel(t('Task ID'))
        ->setDescription(t('The task ID.'))
        ->setReadOnly(TRUE)
        ->setSetting('unsigned', TRUE);

    $fields['uuid'] = FieldDefinition::create('uuid')
        ->setLabel(t('UUID'))
        ->setDescription(t('The task UUID.'))
        ->setReadOnly(TRUE);

    $fields['langcode'] = FieldDefinition::create('language')
        ->setLabel(t('Language code'))
        ->setDescription(t('The task language code.'));

    $fields['type'] = FieldDefinition::create('entity_reference')
        ->setLabel(t('Task type'))
        ->setDescription(t('The task type.'))
        ->setSetting('target_type', 'task_type')
        ->setSetting('max_length', EntityTypeInterface::BUNDLE_MAX_LENGTH);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function uri() {
    return array(
      'path' => 'task/' . $this->id(),
      'options' => array(
        'entity_type' => $this->entityType,
        'entity' => $this,
      )
    );
  }

}
