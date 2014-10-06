<?php

/**
 * @file
 * Contains \Drupal\task\Form\TaskDeleteForm.
 */

namespace Drupal\task\Form;

use Drupal\Core\Entity\ContentEntityConfirmFormBase;

/**
 * Provides a confirmation form for deleting a task entity
 */
class TaskDeleteForm extends ContentEntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete %name?', array('%name' => $this->entity->label()));
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelRoute() {
    return array(
      'route_name' => 'task.task_view',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function submit(array $form, array &$form_state) {
    $this->entity->delete();
    drupal_set_message($this->t('Task %label has been deleted.', array('%label' => $this->entity->label())));
    watchdog('task', 'Task %label has been deleted.', array('%label' => $this->entity->label()), WATCHDOG_NOTICE);
    $form_state['redirect_route']['route_name'] = 'task.type_list';
  }

}
