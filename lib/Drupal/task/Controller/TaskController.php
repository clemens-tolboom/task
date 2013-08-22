<?php

/**
 * @file
 * Contains \Drupal\task\Controller\TaskController
 */

namespace Drupal\task\Controller;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Controller\ControllerInterface;
use Drupal\Core\Entity\EntityStorageControllerInterface;
use Drupal\task\TaskTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class TaskController implements ControllerInterface {

  /**
   * The entity manager.
   *
   * @var \Drupal\Component\Plugin\PluginManagerInterface
   */
  protected $entityManager;

  /**
   * The task storage controller.
   *
   * @var \Drupal\Core\Entity\EntityStorageControllerInterface
   */
  protected $TaskStorage;

  /**
   * The task type storage controller.
   *
   * @var \Drupal\Core\Entity\EntityStorageControllerInterface
   */
  protected $TaskTypeStorage;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $entity_manager = $container->get('plugin.manager.entity');
    return new static(
      $entity_manager,
      $entity_manager->getStorageController('task'),
      $entity_manager->getStorageController('task_type')
    );
  }

  /**
   * Constructs a Task object.
   *
   * @param \Drupal\Component\Plugin\PluginManagerInterface $entity_manager
   *   The entity manager.
   * @param \Drupal\Core\Entity\EntityStorageControllerInterface $task_storage
   *   The task storage controller.
   * @param \Drupal\Core\Entity\EntityStorageControllerInterface $task_type_storage
   *   The task type storage controller.
   */
  public function __construct(PluginManagerInterface $entity_manager, EntityStorageControllerInterface $task_storage, EntityStorageControllerInterface $task_type_storage) {
    $this->TaskStorage = $task_storage;
    $this->TaskTypeStorage = $task_type_storage;
    $this->entityManager = $entity_manager;
  }

  /**
   * Displays add task links for available types.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request object.
   *
   * @return array
   *   A render array for a list of the task types that can be added or
   *   if there is only one task type defined for the site, the function
   *   returns the task add page for that task type.
   */
  public function add(Request $request) {
    $types = $this->TaskTypeStorage->loadMultiple();
    if ($types && count($types) == 1) {
      $type = reset($types);
      return $this->addForm($type, $request);
    }

    return array('#theme' => 'task_add_list', '#content' => $types);
  }

  /**
   * Presents the task creation form.
   *
   * @param \Drupal\task\TaskTypeInterface $task_type
   *   The task type to add.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request object.
   *
   * @return array
   *   A form array as expected by drupal_render().
   */
  public function addForm(TaskTypeInterface $task_type, Request $request) {
    // @todo Remove this when https://drupal.org/node/1981644 is in.
    drupal_set_title(t('Add %type task', array(
      '%type' => $task_type->label()
    )), PASS_THROUGH);
    $block = $this->TaskStorage->create(array(
      'type' => $task_type->id()
    ));

    return $this->entityManager->getForm($block);
  }

}
