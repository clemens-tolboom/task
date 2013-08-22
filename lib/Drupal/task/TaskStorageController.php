<?php

/**
 * @file
 * Contains \Drupal\task\TaskStorageController.
 */

namespace Drupal\task;

use Drupal\Core\Entity\DatabaseStorageControllerNG;
use Drupal\Core\Entity\EntityStorageControllerInterface;

/**
 * Controller class for tasks.
 *
 * This extends the Drupal\Core\Entity\DatabaseStorageControllerNG class,
 * adding required special handling for task entities.
 */
class TaskStorageController extends DatabaseStorageControllerNG implements EntityStorageControllerInterface {

  /**
   * Implements \Drupal\Core\Entity\DataBaseStorageControllerNG::basePropertyDefinitions().
   */
  public function baseFieldDefinitions() {
    $properties['id'] = array(
      'label' => t('ID'),
      'description' => t('The custom task ID.'),
      'type' => 'integer_field',
      'read-only' => TRUE,
    );
    $properties['uuid'] = array(
      'label' => t('UUID'),
      'description' => t('The custom task UUID.'),
      'type' => 'uuid_field',
    );
    $properties['langcode'] = array(
      'label' => t('Language code'),
      'description' => t('The task language code.'),
      'type' => 'language_field',
    );
    $properties['name'] = array(
      'label' => t('Subject'),
      'description' => t('The custom task name.'),
      'type' => 'string_field',
    );
    $properties['type'] = array(
      'label' => t('task type'),
      'description' => t('The task type.'),
      'type' => 'string_field',
    );
    $properties['description'] = array(
      'label' => t('Task description'),
      'description' => t('The task description'),
      'type' => 'string_field',
    );
    return $properties;
  }

}
