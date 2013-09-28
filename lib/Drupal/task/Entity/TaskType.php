<?php

/**
 * @file
 * Contains \Drupal\task\Plugin\Core\Entity\TaskType.
 */

namespace Drupal\task\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Entity\Annotation\EntityType;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\EntityStorageControllerInterface;
use Drupal\task\TaskTypeInterface;

/**
 * Defines the task type entity.
 *
 * @EntityType(
 *   id = "task_type",
 *   label = @Translation("Task type"),
 *   module = "task",
 *   controllers = {
 *     "storage" = "Drupal\Core\Config\Entity\ConfigStorageController",
 *     "access" = "Drupal\task\TaskTypeAccessController",
 *     "form" = {
 *       "default" = "Drupal\task\TaskTypeFormController",
 *       "add" = "Drupal\task\TaskTypeFormController",
 *       "edit" = "Drupal\task\TaskTypeFormController",
 *       "delete" = "Drupal\task\Form\TaskTypeDeleteForm"
 *     },
 *     "list" = "Drupal\task\TaskTypeListController"
 *   },
 *   config_prefix = "task.type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "edit-form" = "admin/structure/task-types/manage/{task_type}"
 *   }
 * )
 */
class TaskType extends ConfigEntityBase implements TaskTypeInterface {

  /**
   * The task type ID.
   *
   * @var string
   */
  public $id;

  /**
   * The task type UUID.
   *
   * @var string
   */
  public $uuid;

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
}
