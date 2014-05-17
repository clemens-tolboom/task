<?php

/**
 * @file
 * Contains \Drupal\task\Form\TaskTypeDeleteForm.
 */

namespace Drupal\task\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;

/**
 * Provides a confirmation form for deleting a task type entity.
 */
class TaskTypeDeleteForm extends EntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete the task type %label?', array('%label' => $this->entity->label()));
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelRoute() {
    return array(
      'route_name' => 'task.type_list',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function submit(array $form, array &$form_state) {
    $this->entity->delete();
    drupal_set_message(t('task type %label has been deleted.', array('%label' => $this->entity->label())));
    watchdog('task', 'task type %label has been deleted.', array('%label' => $this->entity->label()), WATCHDOG_NOTICE);
    $form_state['redirect_route'] = $this->getCancelRoute();
  }

}
