<?php
/**
 * @file
 * Hooks provided by this module.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Acts on task being loaded from the database.
 *
 * This hook is invoked during $task loading, which is handled by
 * entity_load(), via the EntityCRUDController.
 *
 * @param array $entities
 *   An array of $task entities being loaded, keyed by id.
 *
 * @see hook_entity_load()
 */
function hook_task_load(array $entities) {
  $result = db_query('SELECT pid, foo FROM {mytable} WHERE pid IN(:ids)', array(':ids' => array_keys($entities)));
  foreach ($result as $record) {
    $entities[$record->pid]->foo = $record->foo;
  }
}

/**
 * Responds when a $task is inserted.
 *
 * This hook is invoked after the $task is inserted into the database.
 *
 * @param Task $task
 *   The $task that is being inserted.
 *
 * @see hook_entity_insert()
 */
function hook_task_insert(Task $task) {
  db_insert('mytable')
    ->fields(array(
      'id' => entity_id('task', $task),
      'extra' => print_r($task, TRUE),
    ))
    ->execute();
}

/**
 * Acts on a $task being inserted or updated.
 *
 * This hook is invoked before the $task is saved to the database.
 *
 * @param Task $task
 *   The $task that is being inserted or updated.
 *
 * @see hook_entity_presave()
 */
function hook_task_presave(Task $task) {
  $task->name = 'foo';
}

/**
 * Responds to a $task being updated.
 *
 * This hook is invoked after the $task has been updated in the database.
 *
 * @param Task $task
 *   The $task that is being updated.
 *
 * @see hook_entity_update()
 */
function hook_task_update(Task $task) {
  db_update('mytable')
    ->fields(array('extra' => print_r($task, TRUE)))
    ->condition('id', entity_id('task', $task))
    ->execute();
}

/**
 * Responds to $task deletion.
 *
 * This hook is invoked after the $task has been removed from the database.
 *
 * @param Task $task
 *   The $task that is being deleted.
 *
 * @see hook_entity_delete()
 */
function hook_task_delete(Task $task) {
  db_delete('mytable')
    ->condition('pid', entity_id('task', $task))
    ->execute();
}

/**
 * Act on a task that is being assembled before rendering.
 *
 * @param $task
 *   The task entity.
 * @param $view_mode
 *   The view mode the task is rendered in.
 * @param $langcode
 *   The language code used for rendering.
 *
 * The module may add elements to $task->content prior to rendering. The
 * structure of $task->content is a renderable array as expected by
 * drupal_render().
 *
 * @see hook_entity_prepare_view()
 * @see hook_entity_view()
 */
function hook_task_view($task, $view_mode, $langcode) {
  $task->content['my_additional_field'] = array(
    '#markup' => $additional_field,
    '#weight' => 10,
    '#theme' => 'mymodule_my_additional_field',
  );
}

/**
 * Alter the results of entity_view() for tasks.
 *
 * @param $build
 *   A renderable array representing the task content.
 *
 * This hook is called after the content has been assembled in a structured
 * array and may be used for doing processing which requires that the complete
 * task content structure has been built.
 *
 * If the module wishes to act on the rendered HTML of the task rather than
 * the structured content array, it may use this hook to add a #post_render
 * callback. Alternatively, it could also implement hook_preprocess_task().
 * See drupal_render() and theme() documentation respectively for details.
 *
 * @see hook_entity_view_alter()
 */
function hook_task_view_alter($build) {
  if ($build['#view_mode'] == 'full' && isset($build['an_additional_field'])) {
    // Change its weight.
    $build['an_additional_field']['#weight'] = -10;

    // Add a #post_render callback to act on the rendered HTML of the entity.
    $build['#post_render'][] = 'my_module_post_render';
  }
}

/**
 * Acts on task_type being loaded from the database.
 *
 * This hook is invoked during task_type loading, which is handled by
 * entity_load(), via the EntityCRUDController.
 *
 * @param array $entities
 *   An array of task_type entities being loaded, keyed by id.
 *
 * @see hook_entity_load()
 */
function hook_task_type_load(array $entities) {
  $result = db_query('SELECT pid, foo FROM {mytable} WHERE pid IN(:ids)', array(':ids' => array_keys($entities)));
  foreach ($result as $record) {
    $entities[$record->pid]->foo = $record->foo;
  }
}

/**
 * Responds when a task_type is inserted.
 *
 * This hook is invoked after the task_type is inserted into the database.
 *
 * @param TaskType $task_type
 *   The task_type that is being inserted.
 *
 * @see hook_entity_insert()
 */
function hook_task_type_insert(TaskType $task_type) {
  db_insert('mytable')
    ->fields(array(
      'id' => entity_id('task_type', $task_type),
      'extra' => print_r($task_type, TRUE),
    ))
    ->execute();
}

/**
 * Acts on a task_type being inserted or updated.
 *
 * This hook is invoked before the task_type is saved to the database.
 *
 * @param TaskType $task_type
 *   The task_type that is being inserted or updated.
 *
 * @see hook_entity_presave()
 */
function hook_task_type_presave(TaskType $task_type) {
  $task_type->name = 'foo';
}

/**
 * Responds to a task_type being updated.
 *
 * This hook is invoked after the task_type has been updated in the database.
 *
 * @param TaskType $task_type
 *   The task_type that is being updated.
 *
 * @see hook_entity_update()
 */
function hook_task_type_update(TaskType $task_type) {
  db_update('mytable')
    ->fields(array('extra' => print_r($task_type, TRUE)))
    ->condition('id', entity_id('task_type', $task_type))
    ->execute();
}

/**
 * Responds to task_type deletion.
 *
 * This hook is invoked after the task_type has been removed from the database.
 *
 * @param TaskType $task_type
 *   The task_type that is being deleted.
 *
 * @see hook_entity_delete()
 */
function hook_task_type_delete(TaskType $task_type) {
  db_delete('mytable')
    ->condition('pid', entity_id('task_type', $task_type))
    ->execute();
}

/**
 * Define default task_type configurations.
 *
 * @return
 *   An array of default task_type, keyed by machine names.
 *
 * @see hook_default_task_type_alter()
 */
function hook_default_task_type() {
  $defaults['main'] = entity_create('task_type', array(
    // …
  ));
  return $defaults;
}

/**
 * Alter default task_type configurations.
 *
 * @param array $defaults
 *   An array of default task_type, keyed by machine names.
 *
 * @see hook_default_task_type()
 */
function hook_default_task_type_alter(array &$defaults) {
  $defaults['main']->name = 'custom name';
}
