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
       'pluginsDir'     => COREROOT . '/app/plugins/' ,
       'libraryDir'     => COREROOT . '/app/library/' ,
       'helpersDir'     => COREROOT . '/app/helpers/' ,
       'cacheDir'       => COREROOT . '/app/cache/' ,
       'tasksDir'       => COREROOT . '/app/tasks/' ,
       'traitsDir'      => COREROOT . '/app/traits/' ,
       'tmpDir'         => PUBLICROOT . '/temp/' ,
       'filesDir'       => PUBLICROOT . '/files/' ,
       'publicDir'      => PUBLICROOT . '/' ,
       'baseUri'        => 'http://phalcon-admin.local/' ,
       'imagesUri'      => 'http://phalcon-admin.local/' ,
       'siteUri'        => 'http://phalcon-admin.local/' ,
       'cookieDomain'   => '.phalcon-admin.local' ,
   ] ,
   'site'        => [
       'name' => 'Phalcon Admin'
   ]
]);
