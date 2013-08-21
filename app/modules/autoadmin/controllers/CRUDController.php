<?php

namespace AutoAdmin\Controllers;

use AutoAdmin\Fields\Field;
use AutoAdmin\Helpers\EntityManager;
use AutoAdmin\Helpers\ModelReader;
use AutoAdmin\Models\AdminUsers;
use AutoAdmin\Widgets\Widget;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Paginator\Adapter\Model as ModelPaginator;

/**
 * @property EntityManager entityManager
 */
abstract class CRUDController extends BaseController
{

    /**
     * Главная страница панели управления
     */
    public function indexAction()
    {
        $entities = $this->entityManager->getAll();
        $users    = AdminUsers::find();

        $this->view->pick('CRUD/index');
        $this->view->setVars(
            [
            'entities' => $entities ,
            'users'    => $users
            ]
        );
    }

    /**
     * Список объектов активной модели
     */
    public function listAction()
    {
        /** @var mixed $entity */
        $entity = $this->getModelName();
        $items  = $entity::find();
        $pages  = new ModelPaginator([
                                     'data'  => $items ,
                                     'limit' => 15 ,
                                     'page'  => $this->request->get('page' , 'int') ? : 1
                                     ]);

        $model_reader = new ModelReader($entity , Field::GROUP_TABLE);
        $fields       = $model_reader->read();

        Widget::factory('Breadcrumbs' , true)->add(
            $this->entityManager->getProperty($entity , 'title') ,
            $this->url->get([ 'for' => 'admin-entity' , 'entity' => $entity ])
        );

        // Get the paginated results
        $page = $pages->getPaginate();

        $this->view->pick('CRUD/list');
        $this->view->setVars(
            [
            'items'     => $page->items ,
            'fields'    => $fields ,
            'paginator' => $page
            ]
        );
    }

    /**
     * Страница редактирования объекта текущей модели
     * @param int $id
     */
    public function editAction($id = 0)
    {
        /** @var mixed $entity */
        $entity = $this->getModelName();
        $item   = (int) $id ? $entity::findFirst($id) : new $entity();

        $model_reader = new ModelReader($entity , Field::GROUP_FORM);
        $fields       = $model_reader->read();

        $fields->apply('setModel' , [ $item ]);

        Widget::factory('Breadcrumbs' , true)->add(
            $this->entityManager->getProperty($entity , 'title') ,
            $this->url->get([ 'for' => 'admin-entity' , 'entity' => $entity ])
        )->add(
                (int) $id ? 'Редактировать' : 'Создать' ,
                $this->url->get([ 'for' => 'admin-action' , 'entity' => $entity , 'action' => 'edit' ])
            );

        $this->view->pick('CRUD/edit');
        $this->view->setVars(
            [
            'item'   => $item ,
            'fields' => $fields
            ]
        );
    }

    /**
     * Сохранение созданного/отредактированного объекта текущей модели
     *
     * @param int $id
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function saveAction($id = 0)
    {
        if ( !$this->request->isPost() ) {

            return $this->response->redirect();
        }

        $entity = $this->getModelName();
        /** @var ModelInterface $item */
        $item = (int) $id ? $entity::findFirst($id) : new $entity();
        $data = $this->request->getPost('properties');

        $item->assign($data);

        $model_reader = new ModelReader($entity , Field::GROUP_FORM);
        $fields       = $model_reader->read();
        $fields->apply('beforeSave' , [ $item ]);

        if ( $item->save() ) {
            $this->flashSession->success('Сохранено');
        } else {

            foreach ( $item->getMessages() as $message ) {
                $this->flashSession->error($message);
            }
        }

        $fields->apply('afterSave' , [ $item ]);

        return $this->response->redirect(
            [
            'for'    => 'admin-action' ,
            'entity' => $this->dispatcher->getParam('entity') ,
            'action' => 'edit' ,
            'params' => $item->id
            ]
        );
    }

    /**
     * Удаление объекта текущей модели
     *
     * @param $id
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function deleteAction($id)
    {
        $entity = $this->getModelName();
        /** @var ModelInterface $item */
        $item = $entity::findFirst($id);

        if ( $item->delete() ) {
            $this->flashSession->success('Удалено');
        } else {
            $this->flashSession->error('Потрачено');
        }

        return $this->response->redirect(
            [
            'for'    => 'admin-entity' ,
            'entity' => $this->dispatcher->getParam('entity')
            ]
        );
    }

}
