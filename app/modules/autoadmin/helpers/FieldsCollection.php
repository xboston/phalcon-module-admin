<?php

namespace AutoAdmin\Helpers {

    use AutoAdmin\Fields\Field;

    class FieldsCollection
    {

        /** @var Field[] */
        protected $_fields = array();

        /**
         * @param Field|Field[] $field
         * @return $this
         */
        public function add($field)
        {
            if ( ! is_array($field)) {
                $field = [$field];
            }

            $this->_fields = array_merge($this->_fields, $field);

            return $this;
        }

        /**
         * @param string $name
         * @param array $arguments
         */
        public function apply($name, $arguments = array())
        {
            array_map(
                function ($field) use ($name, $arguments) {
                    call_user_func_array([$field, $name], $arguments);
                },
                $this->_fields
            );
        }

        public function toArray()
        {
            return $this->_fields;
        }

    }
}
