<?php

namespace Admin\Controllers;

use Phalcon\Mvc\View;

class BaseController extends AdminController
{

    public function initialize()
    {

        parent::initialize();
        $this->view->setViewsDir(ADMINROOT . '/views/');

        $entityElements = $this->config->entityElements;
        $this->entityManager->setEntities($entityElements->toArray());
    }
}
