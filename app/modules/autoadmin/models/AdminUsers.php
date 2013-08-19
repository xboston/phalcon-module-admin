<?php

namespace AutoAdmin\Models {

    use Phalcon\Mvc\Model;

    class AdminUsers extends Model
    {

        /** @var int */
        public $id;
        /** @var string */
        public $username;
        /** @var string */
        public $email;
        /** @var string */
        public $password;
        /** @var bool */
        public $active;
        /** @var string */
        public $last_login;
        /** @var string */
        public $created_at;

    }
}
