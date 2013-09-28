<?php

/**
 * @file
 * Contains \Drupal\task\Controller\TaskController
 */

namespace Drupal\task\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\task\TaskTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends ControllerBase {

  public function add() {
    $types = $this->entityManager()->getStorageController('task_type')->loadMultiple();
    if ($types && count($types) == 1) {
      $type = reset($types);
      return $this->addForm($type);
    }

    return array('#theme' => 'task_add_list', '#content' => $types);
  }

  /**
   * Presents the task creation form.
   *
   * @param \Drupal\task\TaskTypeInterface $task_type
   *   The task type to add.
   *
   * @return array
   *   A form array as expected by drupal_render().
   */
  public function addForm(TaskTypeInterface $task_type) {
    $task = $this->entityManager()->getStorageController('task')->create(array('type' => $task_type->id()));
    return $this->entityManager->getForm($task);
  }

}
