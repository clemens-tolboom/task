<?php

/**
 * @file
 * Contains \Drupal\task\TaskTypeFormController.
 */

namespace Drupal\task;

use Drupal\Core\Entity\EntityForm;

/**
 * Base form controller for category edit forms.
 */
class TaskTypeForm extends EntityForm {

  /**
   * Overrides \Drupal\Core\Entity\EntityFormController::form().
   */
  public function form(array $form, array &$form_state) {
    $form = parent::form($form, $form_state);

    $task_type = $this->entity;

    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => t('Label'),
      '#maxlength' => 255,
      '#default_value' => $task_type->label(),
      '#description' => t("Provide a label for this task type to help identify it in the administration pages."),
      '#required' => TRUE,
    );
    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $task_type->id(),
      '#machine_name' => array(
        'exists' => 'task_type_load',
      ),
      '#disabled' => !$task_type->isNew(),
    );

    $form['description'] = array(
      '#type' => 'textarea',
      '#default_value' => $task_type->description,
      '#description' => t('Enter a description for this task type.'),
      '#title' => t('Description'),
    );

    $form['revision'] = array(
      '#type' => 'checkbox',
      '#title' => t('Create new revision'),
      '#default_value' => $task_type->revision,
      '#description' => t('Create a new revision by default for this task type.')
    );

    if ($this->moduleHandler->moduleExists('content_translation')) {
      $form['language'] = array(
          '#type' => 'details',
          '#title' => t('Language settings'),
          '#group' => 'additional_settings',
      );

      $language_configuration = language_get_default_configuration('task', $task_type->id());
      $form['language']['language_configuration'] = array(
          '#type' => 'language_configuration',
          '#entity_information' => array(
              'entity_type' => 'custom_block',
              'bundle' => $task_type->id(),
          ),
          '#default_value' => $language_configuration,
      );

      $form['#submit'][] = 'language_configuration_element_submit';
    }

    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Save'),
    );

    return $form;
  }

  /**
   * Overrides \Drupal\Core\Entity\EntityFormController::save().
   */
  public function save(array $form, array &$form_state) {
    $task_type = $this->entity;
    $status = $task_type->save();

    $uri = $task_type->uri();
    if ($status == SAVED_UPDATED) {
      drupal_set_message(t('Task type %label has been updated.', array('%label' => $task_type->label())));
      watchdog('task', 'Task type %label has been updated.', array('%label' => $task_type->label()), WATCHDOG_NOTICE, l(t('Edit'), $uri['path'] . '/edit'));
    }
    else {
      drupal_set_message(t('Task type %label has been added.', array('%label' => $task_type->label())));
      watchdog('task', 'Task type %label has been added.', array('%label' => $task_type->label()), WATCHDOG_NOTICE, l(t('Edit'), $uri['path'] . '/edit'));
    }

    $form_state['redirect'] = 'admin/structure/task-types';
  }
}
