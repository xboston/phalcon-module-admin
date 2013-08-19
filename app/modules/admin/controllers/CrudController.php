<?php

namespace Admin\Controllers;

/**
 * @property \AutoAdmin\Helpers\EntityManager entityManager
 */
class CrudController extends \AutoAdmin\Controllers\CRUDController
{

    public function initialize()
    {
        parent::initialize();

        $this->entityManager
            ->add('Posts' ,['title' => 'Посты'])
            ->add('Categories' ,['title' => 'Категории постов'])
            ->add('Users' , ['title' => 'Пользователи'])
            ->add('Full' , ['title' => 'CRUD test'])
            //->add('AutoAdmin\Models\AdminUsers',['title'=>'Администраторы']
            ;
    }

}
