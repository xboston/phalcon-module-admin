<?php

return new \Phalcon\Config([
    'auth' => [
        'hash_method' => 'sha256',
        'hash_key'    => 'secret key',
        'lifetime'    => 3600,
        'session_key' => 'admin_user',
        'salt'        => 'autoadminsalt'
    ],
    '_database'    => [
        'adapter'  => 'Mysql' ,
        'host'     => 'localhost' ,
        'username' => 'root' ,
        'password' => '' ,
        'dbname'   => 'pahlcon_admin' ,
        'charset'  => 'utf8'
    ] ,
    'site'=>[
        'name'=>'Phalcon Admin'
    ],
    'entityElements'=>[
        'Full'=>[
            'title'=>'CRUD test'
        ],
        'Categories'=>[
            'title'=>'Категории'
        ],
        'Posts'=>[
            'title'=>'Посты'
        ],
        'Users'=>[
            'title'=>'Пользователи'
        ],
    ]
]);
