<?php

/**
 * @file
 * Contains \Drupal\task\Form\TaskTypeDeleteForm.
 */

namespace Drupal\task\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Entity\EntityControllerInterface;
use Drupal\Core\Entity\Query\QueryFactory;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides a confirmation form for deleting a task type entity.
 */
class TaskTypeDeleteForm extends EntityConfirmFormBase implements EntityControllerInterface {

  /**
   * The query factory to create entity queries.
   *
   * @var \Drupal\Core\Entity\Query\QueryFactory
   */
  public $queryFactory;

  /**
   * Constructs a query factory object.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface
   *   The module handler service.
   * @param \Drupal\Core\Entity\Query\QueryFactory $query_factory
   *   The entity query object.
   */
  public function __construct(ModuleHandlerInterface $module_handler, QueryFactory $query_factory) {
    parent::__construct($module_handler);
    $this->queryFactory = $query_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, $entity_type, array $entity_info) {
    return new static(
      $container->get('module_handler'),
      $container->get('entity.query')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete %label?', array('%label' => $this->entity->label()));
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelPath() {
    return 'admin/structure/tasks/types';
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state, Request $request = NULL) {
    $tasks = $this->queryFactory->get('task_type')->condition('type', $this->entity->id())->execute();
    if (!empty($tasks)) {
      $caption = '<p>' . format_plural(count($tasks), '%label is used by 1 task on your site. You can not remove this task type until you have removed all of the %label tasks.', '%label is used by @count tasks on your site. You may not remove %label until you have removed all of the %label tasks.', array('%label' => $this->entity->label())) . '</p>';
      $form['description'] = array('#markup' => $caption);
      return $form;
    }
    else {
      return parent::buildForm($form, $form_state, $request);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submit(array $form, array &$form_state) {
    $this->entity->delete();
    $form_state['redirect'] = 'admin/structure/tasks/types';
    drupal_set_message(t('task type %label has been deleted.', array('%label' => $this->entity->label())));
    watchdog('task', 'task type %label has been deleted.', array('%label' => $this->entity->label()), WATCHDOG_NOTICE);
  }

}
