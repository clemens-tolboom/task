<?php

/**
 * @file
 * Contains \Drupal\task\Plugin\Core\Entity\TaskType.
 */

namespace Drupal\task\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\task\TaskTypeInterface;

/**
 * Defines the task type entity.
 *
 * @ConfigEntityType(
 *   id = "task_type",
 *   label = @Translation("Task type"),
 *   handlers = {
 *     "access" = "Drupal\task\TaskTypeAccessController",
 *     "list_builder" = "Drupal\task\TaskTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\task\TaskTypeForm",
 *       "edit" = "Drupal\task\TaskTypeForm",
 *       "delete" = "Drupal\task\Form\TaskTypeDeleteForm"
 *     }
 *   },
 *   config_prefix = "task",
 *   admin_permission = "administer task types",
 *   bundle_of = "task",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   },
 *   links = {
 *     "delete-form" = "task.type_delete",
 *     "edit-form" = "task.type_edit"
 *   }
 * )
 */
class TaskType extends ConfigEntityBundleBase implements TaskTypeInterface {

  /**
   * The task type ID.
   *
   * @var string
   */
  public $id;

  /**
   * The task type label.
   *
   * @var string
   */
  public $label;

  /**
   * The default revision setting for tasks of this type.
   *
   * @var bool
   */
  public $revision;

  /**
   * The description of the task type.
   *
   * @var string
   */
  public $description;

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
