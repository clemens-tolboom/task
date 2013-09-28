<?php

/**
 * @file
 * Contains \Drupal\task\TaskTypeListController.
 */

namespace Drupal\task;

use Drupal\Core\Config\Entity\ConfigEntityListController;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of task types.
 */
class TaskTypeListController extends ConfigEntityListController {

  /**
   * {@inheritdoc}
   */
  public function getOperations(EntityInterface $entity) {
    $operations = parent::getOperations($entity);
    if (\Drupal::moduleHandler()->moduleExists('field_ui')) {
      $uri = $entity->uri();
      $operations['manage-fields'] = array(
        'title' => t('Manage fields'),
        'href' => $uri['path'] . '/fields',
        'options' => $uri['options'],
        'weight' => 0,
      );
      $operations['manage-form-display'] = array(
        'title' => t('Manage form display'),
        'href' => $uri['path'] . '/form-display',
        'options' => $uri['options'],
        'weight' => 5,
      );
      $operations['manage-display'] = array(
        'title' => t('Manage display'),
        'href' => $uri['path'] . '/display',
        'options' => $uri['options'],
        'weight' => 10,
      );
    }
    return $operations;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $row['type'] = t('Task type');
    $row['description'] = t('Description');
    $row['operations'] = t('Operations');
    return $row;
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    parent::buildRow($entity);
    $uri = $entity->uri();
    $row['type'] = l($entity->label(), $uri['path'], $uri['options']);
    $row['description'] = filter_xss_admin($entity->description);
    $row['operations']['data'] = $this->buildOperations($entity);
    return $row;
  }

}
