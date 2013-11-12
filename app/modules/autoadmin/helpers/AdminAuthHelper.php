<?php

namespace AutoAdmin\Helpers {

    use AutoAdmin\Models\AdminUsers;
    use Phalcon\DI;

    class AdminAuthHelper extends \Phalcon\Mvc\User\Plugin

    {


        protected $_config;
        /** @var \Phalcon\Session\AdapterInterface */
        protected $_session;

        protected static $_instance;

        /**
         * @return AdminAuthHelper
         */
        public static function instance()
        {
            if ( self::$_instance === null ) {

                self::$_instance = new self;
            }

            return self::$_instance;
        }


        private function __construct()
        {
            $this->_config  = $this->config->auth;
            $this->_session = $this->session;
        }

        /**
         * @return mixed
         */
        public function getUser()
        {
            $userId = (int) $this->_session->get($this->_config['session_key'] , false);

            return $userId ? AdminUsers::findFirstById($userId) : false;
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
            $user = AdminUsers::findFirstByUsername($username);

            if ( !$user || !$user->active || !$this->security->checkHash($password , $user->password) ) {

                return false;
            }

            $this->_session->set($this->_config['session_key'] , $user->id);

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
}
