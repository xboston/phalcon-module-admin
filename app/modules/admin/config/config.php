<?php

return new \Phalcon\Config([
    'auth' => [
        'hash_method' => 'sha256',
        'hash_key'    => 'secret key',
        'lifetime'    => 3600,
        'session_key' => 'admin_user',
        'salt'        => 'autoadminsalt'
    ],
    'database'    => [
        'adapter'  => 'Mysql' ,
        'host'     => 'localhost' ,
        'username' => 'root' ,
        'password' => '' ,
        'dbname'   => 'pahlcon_admin' ,
        'charset'  => 'utf8'
    ] ,
]);
