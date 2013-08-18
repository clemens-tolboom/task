<?php

/**
 * @file
 * Contains \Drupal\task\Plugin\Core\Entity\CustomBlockType.
 */

namespace Drupal\task\Plugin\Core\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Entity\Annotation\EntityType;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\EntityStorageControllerInterface;
use Drupal\task\CustomBlockTypeInterface;

/**
 * Defines the task type entity.
 *
 * @EntityType(
 *   id = "task_type",
 *   label = @Translation("Task type"),
 *   module = "task",
 *   controllers = {
 *     "storage" = "Drupal\Core\Config\Entity\ConfigStorageController",
 *     "access" = "Drupal\task\CustomBlockTypeAccessController",
 *     "form" = {
 *       "default" = "Drupal\task\CustomBlockTypeFormController",
 *       "add" = "Drupal\task\CustomBlockTypeFormController",
 *       "edit" = "Drupal\task\CustomBlockTypeFormController",
 *       "delete" = "Drupal\task\Form\CustomBlockTypeDeleteForm"
 *     },
 *     "list" = "Drupal\task\CustomBlockTypeListController"
 *   },
 *   config_prefix = "task.type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   }
 * )
 */
class CustomBlockType extends ConfigEntityBase implements TaskTypeInterface {

  /**
   * The custom block type ID.
   *
   * @var string
   */
  public $id;

  /**
   * The custom block type UUID.
   *
   * @var string
   */
  public $uuid;

  /**
   * The custom block type label.
   *
   * @var string
   */
  public $label;

  /**
   * The default revision setting for custom blocks of this type.
   *
   * @var bool
   */
  public $revision;

  /**
   * The description of the block type.
   *
   * @var string
   */
  public $description;

  /**
   * Overrides \Drupal\Core\Entity\Entity::uri().
   */
  public function uri() {
    return array(
      'path' => 'admin/structure/custom-blocks/manage/' . $this->id(),
      'options' => array(
        'entity_type' => $this->entityType,
        'entity' => $this,
      )
    );
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(EntityStorageControllerInterface $storage_controller, $update = TRUE) {
    /*
    if (!$update) {
      entity_invoke_bundle_hook('create', 'task', $this->id());
      task_add_body_field($this->id);
    }
    elseif ($this->originalID != $this->id) {
      entity_invoke_bundle_hook('rename', 'task', $this->originalID, $this->id);
    }*/

  }

  /**
   * {@inheritdoc}
   */
  public static function postDelete(EntityStorageControllerInterface $storage_controller, array $entities) {
    /*
    foreach ($entities as $entity) {
      entity_invoke_bundle_hook('delete', 'task', $entity->id());
    }
    */
  }
}
