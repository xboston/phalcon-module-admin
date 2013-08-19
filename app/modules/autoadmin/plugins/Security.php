<?php
namespace AutoAdmin\Plugins;

use AutoAdmin\Helpers\Auth;
use Phalcon\DI;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\User\Plugin;

class Security extends Plugin
{

    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @return bool
     */
    public function beforeDispatch($event, $dispatcher)
    {

        $controller = $dispatcher->getControllerName();
        $action     = $dispatcher->getActionName();

        if ($controller == 'admin' && $action == 'login') {

            return true;
        }

        if ( ! Auth::instance()->loggedIn()) {

            $dispatcher->forward(['controller' => 'admin', 'action' => 'login']);
            return false;
        }

        return true;
    }

}
