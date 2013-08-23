<?php

namespace AutoAdmin\Controllers;

use AutoAdmin\Helpers\AdminAuthHelper;
use AutoAdmin\Models\AdminUsers;

class AdminController extends BaseController
{

    public function indexAction()
    {

    }

    public function loginAction()
    {

        if ( $this->request->isPost() && $this->security->checkToken() ) {

            //$this->view->disable();

            $username = $this->request->getPost('username' , 'string');
            $password = $this->request->getPost('password' , 'string');

            if ( !AdminAuthHelper::instance()->login($username , $password) ) {
                $this->flashSession->error('Неверное имя пользователя или пароль');

                //return false;
            } else {

                /** @var AdminUsers $user */
                $user = AdminAuthHelper::instance()->getUser();
                $user->save([ 'last_login' => date(DATE_ISO8601) ]);

                $this->flashSession->notice(sprintf('С возвращением, %s' , $user->username));
                $this->response->redirect([ 'for' => 'admin' ]);
            }

        }
        $this->view->setLayout('login');
    }

    public function logoutAction()
    {
        AdminAuthHelper::instance()->logout();

        return $this->response->redirect([ 'for' => 'admin' ]);
    }

}
