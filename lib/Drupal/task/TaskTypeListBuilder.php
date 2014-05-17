<?php

/**
 * @file
 * Contains \Drupal\task\TaskTypeListController.
 */

namespace Drupal\task;

use Drupal\Component\Utility\String;
use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of task types.
 */
class TaskTypeListBuilder extends ConfigEntityListBuilder {

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
    $row['description'] = String::checkPlain($entity->description);
    $row['operations']['data'] = $this->buildOperations($entity);
    return $row;
  }

}
