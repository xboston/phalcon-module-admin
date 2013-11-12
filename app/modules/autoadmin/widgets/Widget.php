<?php


namespace AutoAdmin\Widgets {

    abstract class Widget extends \Phalcon\Mvc\User\Component
    {

        protected $_view;

        private static $_instances;

        /**
         * @param string $widgetName
         * @param bool $single
         * @return bool|mixed
         */
        public static function factory($widgetName, $single = false)
        {

            if (!$single || empty(self::$_instances[$widgetName])){

                $class = $widgetName;
                if ( ! class_exists($class)) {
                    $class = __NAMESPACE__ . '\\' . $class;
                }

                if ( ! class_exists($class)) {
                    return false;
                }

                $instance = new $class;

                if ($single){
                    self::$_instances[$widgetName] = $instance;
                }

            }

            if ($single && empty($instance)){
                $instance = self::$_instances[$widgetName];
            }

            return $instance;
        }

        public function __construct()
        {

            $viewsDir = __DIR__ . '/../views/widgets/';

            $this->_view = new \Phalcon\Mvc\View();
            $this->_view->setViewsDir($viewsDir);

            $this->initialize();

        }

        protected function initialize()
        {

        }

        protected function beforeRender()
        {

        }

        public function render($layout = 'default')
        {

            $this->beforeRender();

            preg_match('/[^\\\]+$/ui', get_called_class(), $matches);
            $widgetName = strtolower($matches[0]);

            $this->_view->setLayout($layout);
            ob_start();
            $this->_view->render($widgetName, $layout);

            return ob_get_clean();
        }

    }
}
