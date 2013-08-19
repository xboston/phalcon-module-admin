<?php

namespace AutoAdmin\Controllers;

use AutoAdmin\Helpers\Auth;
use AutoAdmin\Models\AdminUsers;

class AdminController extends BaseController
{

    public function indexAction()
    {

    }

    public function loginAction()
    {

        if ( $this->request->isPost() && $this->security->checkToken() ) {

            $this->view->disable();

            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            if ( !Auth::instance()->login($username , $password) ) {
                $this->flashSession->error('Неверное имя пользователя или пароль');

            } else {

                /** @var AdminUsers $user */
                $user = Auth::instance()->getUser();
                $user->save([ 'last_login' => date(DATE_ISO8601) ]);
            }
            $this->response->redirect([ 'for' => 'admin' ]);
        }

        $this->flashSession->error('Ошибка безопасности');

        // тут надо указывать совсем другой лайут, с меньшим числом проверок авторизации (юзер итак на странице логина - он точно не в теме, же)
        //$this->view->setLayout('login');

    }

    public function logoutAction()
    {
        Auth::instance()->logout();

        return $this->response->redirect([ 'for' => 'admin' ]);
    }

}
