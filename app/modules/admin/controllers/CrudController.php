<?php

namespace Admin\Controllers {

    /**
     * @property \AutoAdmin\Helpers\EntityManager entityManager
     */
    class CrudController extends \AutoAdmin\Controllers\CRUDController
    {

        public function initialize()
        {
            parent::initialize();

            $entityElements = $this->config->entityElements;

            $this->entityManager->setEntities($entityElements->toArray());

            //$this->entityManager
            //->add('AutoAdmin\Models\AdminUsers',['title'=>'Администраторы']
            ;
        }

    }
}
