<?php

/**
 * Task view callback.
 */
function task_view($task) {
  drupal_set_title(entity_label('task', $task));
  return entity_view('task', array(entity_id('task', $task) => $task), 'full');
}
