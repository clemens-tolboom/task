<?php

/**
 * @file
 * Contains \Drupal\task\Plugin\Core\Entity\Task.
 */

namespace Drupal\task\Plugin\Core\Entity;

use Drupal\Core\Entity\EntityNG;
use Drupal\Core\Entity\EntityStorageControllerInterface;
use Drupal\Core\Entity\Annotation\EntityType;
use Drupal\Core\Annotation\Translation;
use Drupal\task\TaskInterface;

/**
 * Defines the task entity class.
 *
 * @EntityType(
 *   id = "task",
 *   label = @Translation("Task"),
 *   bundle_label = @Translation("Task type"),
 *   module = "task",
 *   controllers = {
 *     "storage" = "Drupal\task\TaskStorageController",
 *     "access" = "Drupal\task\TaskAccessController",
 *     "list" = "Drupal\task\TaskListController",
 *     "render" = "Drupal\Core\Entity\EntityRenderController",
 *     "form" = {
 *       "add" = "Drupal\task\TaskFormController",
 *       "edit" = "Drupal\task\TaskFormController",
 *       "default" = "Drupal\task\TaskFormController"
 *     }
 *   },
 *   base_table = "task",
 *   route_base_path = "admin/structure/task/manage/{bundle}",
 *   menu_base_path = "task/%task",
 *   menu_edit_path = "task/%task",
 *   fieldable = TRUE,
 *   entity_keys = {
 *     "id" = "id",
 *     "bundle" = "type",
 *     "label" = "name",
 *     "uuid" = "uuid"
 *   },
 *   bundle_keys = {
 *     "bundle" = "type"
 *   }
 * )
 */
class Task extends EntityNG implements TaskInterface {

  /**
   * The task ID.
   *
   * @var \Drupal\Core\Entity\Field\FieldInterface
   */
  public $id;

  /**
   * The task UUID.
   *
   * @var \Drupal\Core\Entity\Field\FieldInterface
   */
  public $uuid;

  /**
   * The custom task type (bundle).
   *
   * @var \Drupal\Core\Entity\Field\FieldInterface
   */
  public $type;

  /**
   * The task language code.
   *
   * @var \Drupal\Core\Entity\Field\FieldInterface
   */
  public $langcode;

  /**
   * The task description.
   *
   * @var \Drupal\Core\Entity\Field\FieldInterface
   */
  public $name;

  /**
   * The task description.
   *
   * @var \Drupal\Core\Entity\Field\FieldInterface
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
