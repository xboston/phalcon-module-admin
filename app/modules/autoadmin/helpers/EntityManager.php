<?php

namespace AutoAdmin\Helpers {

    class EntityManager extends \Phalcon\Mvc\User\Component
    {

        private $_entities = [ ];

        /**
         * @param string $entityName
         * @param array  $data
         *
         * @return EntityManager $this
         */
        public function add($entityName , $data)
        {
            //@todo: Наверное, проверка существования сущности
            $this->_entities[$entityName] = $data;

            return $this;
        }

        public function setEntities( array $entityElements)
        {
            $this->_entities +=$entityElements;
        }

        /**
         * @param string $entityName
         *
         * @return array|null
         */
        public function get($entityName)
        {
            return isset($this->_entities[$entityName]) ? $this->_entities[$entityName] : null;
        }

        public function getProperty($entityName , $propertyName)
        {
            return isset($this->_entities[$entityName][$propertyName]) ? $this->_entities[$entityName][$propertyName] : null;
        }

        /**
         * @return array
         */
        public function getAll()
        {
            return $this->_entities;
        }

        /**
         * @param string $field
         *
         * @return array
         */
        public function pluck($field)
        {
            return array_map(
                function ($entity) use ($field) {
                    return isset($entity[$field]) ? $entity[$field] : null;
                } ,
                $this->_entities
            );
        }

    }
}
