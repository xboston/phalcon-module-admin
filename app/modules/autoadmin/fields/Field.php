<?php

namespace AutoAdmin\Fields;

use AutoAdmin\Helpers\FieldParams;
use Phalcon\DI;
use Phalcon\Mvc\ModelInterface;
use Phalcon\Mvc\View as View;
use Phalcon\Tag;

class Field
{

    /** @var int */
    const GROUP_FIELD = 'Field';
    /** @var int */
    const GROUP_FORM = 'FormField';
    /** @var int */
    const GROUP_TABLE = 'TableField';
    /** @var int */
    const GROUP_FILTER = 'FilterField';

    /**
     * @param string      $class
     * @param FieldParams $params
     *
     * @return Field|bool
     */
    public static function factory($class , $params = null)
    {
        if ( !class_exists($class) || !is_a($class , '\AutoAdmin\Fields\Field' , true) ) {
            $class = __NAMESPACE__ . '\\' . ucfirst($class) . 'Field';
        }

        if ( !class_exists($class) ) {
            return false;
        }

        return new $class($params);
    }

    /** @var string */
    protected $_type;
    /** @var View */
    protected $_view;
    /** @var ModelInterface */
    protected $_model;
    /** @var FieldParams */
    protected $_params;

    protected $_default_group;

    public function __construct($params = null)
    {
        $this->_params = $params;

        $views_dir = DI::getDefault()->get('admin_views_dir') . '/fields/';
        $type      = $this->getType();

        if ( !file_exists($views_dir . $type) ) {
            $views_dir = AUTOADMINROOT . '/views/fields/';
        }

        $this->_view = new View();
        $this->_view->setViewsDir($views_dir);

        $this->initialize();
    }

    public function initialize()
    {
    }

    /**
     * @param ModelInterface $model
     */
    public function beforeSave($model)
    {
    }

    /**
     * @param ModelInterface $model
     */
    public function afterSave($model)
    {
    }

    public function beforeRender($params)
    {
    }

    /**
     * @param ModelInterface $model
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }

    /**
     * @return string
     */
    public function getType()
    {
        $class = get_called_class();
        $class = substr_count($class , '\\') ? substr($class , strrpos($class , '\\') + 1) : $class;

        return $class;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        if ( !$this->_model ) {
            return '';
        }

        $name = $this->_params->getParam('name');

        return property_exists($this->_model , $name) ? $this->_model->{$name} : (method_exists($this->_model , $name) ? $this->_model->$name() : '');
    }

    public function getLabel()
    {
        return $this->_params->getParam('label' , $this->_params->getParam('name'));
    }

    /**
     * @param string $layout
     *
     * @return string
     */
    protected function getLayoutDir($layout)
    {
        $views_dir = $this->_view->getViewsDir();
        $type      = $this->getType();

        if ( !file_exists($views_dir . $type . '/' . $layout . '.phtml') ) {
            return 'Field';
        }

        return $type;
    }

    /**
     * @param string $layout
     *
     * @return string
     */
    public function render($layout = 'edit')
    {
        $column = $this->_params->getParam('name');
        $prefix = $this->_params->getParam('source');

        $field_id   = ($prefix ? $prefix . '_' : '') . $column;
        $field_name = $prefix ? $prefix . '[' . $column . ']' : $column;

        $defaultParams = $this->_params->getParams();
        unset($defaultParams['name']);

        $tagParams = array_merge(
            [ $field_name ] ,
            $this->_params->getParam('tag' , [ ]) ,
            [ 'value' => $this->getValue() , 'id' => $field_id ] + $defaultParams
        );

        // все параметры уже добавлены, в общем списке они не нужны
        unset($tagParams['tag']);

        $layout = $this->_params->getParam('options.layout' , $layout);

        $this->beforeRender($tagParams);

        $this->_view->setLayout($layout);
        $this->_view->setVars(
            [
            'field'  => $this ,
            'model'  => $this->_model ,
            'params' => $this->_params ,
            'tag'    => $tagParams
            ]
        );

        ob_start();
        $this->_view->render($this->getLayoutDir($layout) , $layout);

        return ob_get_clean();
    }

}
