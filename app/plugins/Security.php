<?php

use Phalcon\Mvc\Dispatcher,
    Phalcon\Events\Event;

class Security extends Phalcon\Mvc\User\Plugin
{

    /**
     * @var Phalcon\Acl\Adapter\Memory
     */
    protected $_acl;

    public function __construct($dependencyInjector)
    {
        $this->_dependencyInjector = $dependencyInjector;
    }

    public function getAcl()
    {
        if (!$this->_acl) {

            $acl = new Phalcon\Acl\Adapter\Memory();

            $acl->setDefaultAction(Phalcon\Acl::DENY);

            //Register roles
            $roles = array(
                'admins' => new Phalcon\Acl\Role('admins'),
                'users' => new Phalcon\Acl\Role('users'),
                'guests' => new Phalcon\Acl\Role('guests')
            );
            foreach($roles as $role){
                $acl->addRole($role);
            }

            //админские ресурсы
            $adminResources = array(
                'admin_admin' => ['logout'],
                'admin_users' => ['*'],
                'admin_seotags' => ['*'],
                'admin_realty' => ['*'],
                'admin_realtydistricts' => ['*'],
                'admin_types' => ['*'],
                'admin_transports' => ['*'],
                'admin_services' => ['*'],
                'admin_images' => ['*'],
                'admin_leisure' => ['*'],
                'admin_events' => ['*']
            );
            foreach($adminResources as $resource => $actions){
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }

            //Юзерские полномочия
            $privateResources = array(
/*                '_users'         => ['merge', 'change'],
                '_index'    => ['index'],
                '_realty'  => ['index', 'show'],
                '_transports'  => ['index', 'show'],
                '_services'  => ['index', 'show'],

                '_error'    => ['error403', 'error404'],
                '_cart'     => ['index', 'add']*/
            );
            foreach($privateResources as $resource => $actions){
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }

            //Всем доступные
            $publicResources = array(
                '_users'         => ['merge', 'change'],
                '_index'    => ['index'],
                '_realty'  => ['index', 'show'],
                '_transports'  => ['index', 'show'],
                '_services'  => ['index', 'show'],
                '_leisure'  => ['index', 'show'],
                '_events'  => ['index', 'show'],
                'admin_admin' => ['index', 'login'],

                '_error'    => ['error403', 'error404'],
                '_cart'     => ['index', 'add']
            );

            foreach($publicResources as $resource => $actions){
                $acl->addResource(new Phalcon\Acl\Resource($resource), $actions);
            }

            foreach($roles as $role){
                foreach($publicResources as $resource => $actions){
                    $acl->allow($role->getName(), $resource, '*');
                }
            }

            foreach($privateResources as $resource => $actions){
                foreach($actions as $action){
                    $acl->allow('users', $resource, $action);
                    $acl->allow('admins', $resource, $action);
                    $acl->deny('guests', $resource, $action);

                }
            }

            foreach($adminResources as $resource => $actions){
                foreach($actions as $action){
                    $acl->allow('admins', $resource, $action);
                    $acl->deny('users', $resource, $action);
                    $acl->deny('guests', $resource, $action);

                }
            }

            $this->_acl = $acl;
        }
        return $this->_acl;
    }

    /**
     * This action is executed before execute any action in the application
     */
    public function beforeDispatch(Phalcon\Events\Event $event, Phalcon\Mvc\Dispatcher $dispatcher)
    {
        $user = Auth::instance()->get_user();
        $role = ! $user ? 'guests' : $user->role;
        $acl  = $this->getAcl();

        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();
        $module     = $dispatcher->getModuleName();
        $namespace  = $module ? ucfirst($module) . '\\Controllers\\' : '';

        $controller_exists = class_exists($namespace . ucfirst($controller) . 'Controller');
        $action_exists     = method_exists($namespace . ucfirst($controller) . 'Controller', $action . 'Action');

        if ($controller_exists && $action_exists) {

            $allowed = $acl->isAllowed($role, $module.'_'.$controller, $action);

            if ($allowed != Phalcon\Acl::ALLOW) {
                $dispatcher->setModuleName('asd');
                $dispatcher->forward(array(
                        'controller' => 'error',
                        'action'     => 'error403'
                    ));

                return false;
            }

           }
    }

    public function beforeDispatchLoop(Phalcon\Events\Event $event, Phalcon\Mvc\Dispatcher $dispatcher) {
        $module     = $dispatcher->getModuleName();
        if (!Auth::instance()->get_user() && $module=='admin') {
            $this->dispatcher->forward(array(
                    'controller' => 'admin',
                    'action'     => 'login'
                ));
        }
    }
}