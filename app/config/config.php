<?php

return new \Phalcon\Config(
[
    'database'    => [
        'adapter'  => 'Mysql' ,
        'host'     => 'localhost' ,
        'username' => 'root' ,
        'password' => '' ,
        'dbname'   => 'phalcon_admin' ,
        'charset'  => 'utf8'
    ] ,
   'application' => [
       'controllersDir' => COREROOT . '/app/controllers/' ,
       'modelsDir'      => COREROOT . '/app/models/' ,
       'viewsDir'       => COREROOT . '/app/views/' ,
       'cacheDir'       => COREROOT . '/app/cache/' ,
       'traitsDir'      => COREROOT . '/app/traits/' ,
       'tmpDir'         => PUBLICROOT . '/temp/' ,
       'filesDir'       => PUBLICROOT . '/files/' ,
       'publicDir'      => PUBLICROOT . '/' ,
       //'baseUri'        => 'http://phalcon-admin.local/' ,
   ] ,
   'site'        => [
       'name' => 'Phalcon Admin'
   ]
]);
