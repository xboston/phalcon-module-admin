<?php

/**
 * @todo переписать на класс, наследующий extends Phalcon\Mvc\Router\Group
 */

$adminRouter = new \Phalcon\Mvc\Router\Group(['namespace'  => 'Admin\Controllers','module'     => 'admin' ,'controller' => 'admin' ]);

$adminRouter->setPrefix('/admin');

$adminRouter->add(
    '/shows' ,['controller' => 'Shows' ,'action'     => 'similarShows']
)->setName('admin-shows');

return $adminRouter;
