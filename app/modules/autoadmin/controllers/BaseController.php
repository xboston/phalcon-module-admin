<?php

namespace AutoAdmin\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Exception;
use AutoAdmin\Widgets\Widget;
use  \Phalcon\Assets\Filters\None as NullFilter;

/**
 * @property \Phalcon\Assets\Manager assets
 */
class BaseController extends Controller
{

    public function initialize()
    {

        $this->assets
            ->collection('autoadmin_css')
            ->setTargetPath('css/final.css')
            ->setTargetUri('assets/css/final.css')
            ->addCss('css/flatly.css')
            ->addCss('css/admin-style.css')
            ->join(true)
            ->addFilter(new NullFilter());

        $this->assets
            ->collection('autoadmin_js')
            ->setTargetPath('js/final.js')
            ->setTargetUri('assets/js/final.js')
            ->addJs('js/libs/jquery.js')
            ->addJs('js/libs/bootstrap.js')
            ->addJs('js/common.js')
            ->join(true)
            ->addFilter(new NullFilter());


        $this->flashSession->setCssClasses(
            array(
                 'error' => 'alert alert-error' ,
                 'success' => 'alert alert-success' ,
                 'notice' => 'alert alert-info' ,
            )
        );

        Widget::factory('Breadcrumbs' , true)->add('Главная' , $this->url->get([ 'for' => 'admin' ]));
    }

    /**
     * @return string
     * @throws \Phalcon\Exception
     */
    protected function getModelName()
    {
        $model = $this->dispatcher->getParam('entity');
        $model = ucfirst($model);

        if ( !class_exists($model) ) {
            throw new Exception('Model ' . $model . ' not found');
        }

        return $model;
    }

}
