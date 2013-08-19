<?php

class IndexController extends \Phalcon\Mvc\Controller
{

    public function indexAction()
    {

        $this->response->redirect([ 'for' => 'admin' ]);
    }

    public function error404Action()
    {

    }

}

