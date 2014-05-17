<?php

/**
 * @file
 * Contains \Drupal\task\TaskFormController.
 */

namespace Drupal\task;

use Drupal\Core\Entity\ContentEntityForm;

/**
 * Form controller for the task edit forms.
 */
class TaskForm extends ContentEntityForm {

  /**
   * Overrides \Drupal\Core\Entity\EntityFormController::save().
   */
  public function save(array $form, array &$form_state) {
    $task = $this->entity;
    $insert = empty($task->id->value);
    $task->save();
    //$watchdog_args = array('@type' => $task->bundle(), '%info' => $task->label());
    //$task_type = entity_load('task_type', $task->type->value);
    //$t_args = array('@type' => $task_type->label(), '%info' => $task->label());
    /*
    if ($insert) {
      watchdog('content', '@type: added %info.', $watchdog_args, WATCHDOG_NOTICE);
      drupal_set_message(t('@type %info has been created.', $t_args));
    }
    else {
      watchdog('content', '@type: updated %info.', $watchdog_args, WATCHDOG_NOTICE);
      drupal_set_message(t('@type %info has been updated.', $t_args));
    }
    */

  }

  /**
   * Overrides \Drupal\Core\Entity\EntityFormController::delete().
   */
  public function delete(array $form, array &$form_state) {
    $destination = array();
    $query = \Drupal::request()->query;
    if (!is_null($query->get('destination'))) {
      $destination = drupal_get_destination();
      $query->remove('destination');
    }
    $task = $this->buildEntity($form, $form_state);
    $form_state['redirect'] = array('task/' . $task->id() . '/delete', array('query' => $destination));
  }

}
