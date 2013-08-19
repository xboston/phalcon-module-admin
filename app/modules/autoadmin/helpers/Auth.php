<?php

namespace AutoAdmin\Helpers;

use AutoAdmin\Models\AdminUsers;
use Phalcon\DI;

class Auth extends \Phalcon\Mvc\User\Plugin

{

    protected static $_instance;

    /**
     * @return Auth
     */
    public static function instance()
    {
        if ( !self::$_instance ) {
            self::$_instance = new Auth();
        }

        return self::$_instance;
    }

    protected $_config;
    /** @var \Phalcon\Session\AdapterInterface */
    protected $_session;

    public function __construct()
    {
        $this->_config  = DI::getDefault()->getShared('config')->auth;
        $this->_session = DI::getDefault()->getShared('session');
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public function hash($string)
    {

         return $this->security->hash($string);
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->_session->get($this->_config['session_key']);
    }

    /**
     * @return bool
     */
    public function loggedIn()
    {
        return (bool) $this->getUser();
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public function login($username , $password)
    {

        /** @var AdminUsers $user */
        $user = AdminUsers::findFirst(
            [
            'conditions' => 'username = :username:' ,
            'bind'       => [ 'username' => $username ]
            ]
        );

        $password = $this->hash($password);

        if ( !$user || !$user->active || $this->security->checkHash($password, $user->password) ) {
            return false;
        }

        $this->_session->set($this->_config['session_key'] , $user);

        return true;
    }

    /**
     * @return bool
     */
    public function logout()
    {
        return $this->_session->destroy();
    }

}
