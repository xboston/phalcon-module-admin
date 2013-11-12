<?php

namespace AutoAdmin\Helpers {

    use AutoAdmin\Fields\Field;
    use Phalcon\Annotations\Adapter\Memory as AnnotationsAdapter;
    use Phalcon\Annotations\Annotation;
    use Phalcon\Annotations\Collection;

    class ModelReader
    {

        protected $_model_name;
        protected $_group;
        protected $_reader;
        protected $_reflector;

        /**
         * @param string $model_name
         * @param string $group
         */
        public function __construct($model_name , $group)
        {
            $this->_model_name = $model_name;
            $this->_group      = $group;
            $this->_reader     = new AnnotationsAdapter();
            $this->_reflector  = $this->_reader->get($model_name);
        }

        /**
         * @return FieldsCollection
         */
        public function read()
        {
            $collection = new FieldsCollection();

            $collection->add($this->processAnnotations($this->_reflector->getPropertiesAnnotations() , 'properties'));
            $collection->add($this->processAnnotations($this->_reflector->getMethodsAnnotations() , 'methods'));
            $collection->add($this->processAnnotations($this->_reflector->getClassAnnotations() , 'class'));

            return $collection;
        }

        /**
         * @param Collection|Collection[] $items
         * @param string                  $source
         *
         * @return array
         */
        protected function processAnnotations($items , $source)
        {
            $fields = [ ];
            if ( empty($items) ) {
                return $fields;
            }

            if ( $items instanceof Collection ) {
                $annotations = $items->getAll($this->_group);
                foreach ( $annotations as $annotation ) {
                    $arguments = $annotation->getArguments();
                    $fields[]  = $this->buildField($arguments , $source);
                }
            } else {
                foreach ( $items as $column => $annotations ) {
                    if ( !$annotations->has($this->_group) ) {
                        continue;
                    }

                    $arguments = array_merge_recursive(
                        $annotations->has('Field') ? $annotations->get('Field')->getArguments() : [ ] ,
                        $annotations->get($this->_group)->getArguments() ? : [ ]
                    );

                    $fields[] = $this->buildField($arguments , $source , $column);
                }
            }

            return $fields;
        }

        /**
         * @param array       $arguments
         * @param string      $source
         * @param string|null $name
         *
         * @return Field|bool
         */
        public function buildField($arguments , $source , $name = null)
        {
            $params = new FieldParams();
            $params->setParams($arguments);
            $params->setParam('source' , $source);
            $params->setParam('name' , $params->getParam('name' , $name));

            $type  = $params->getParam('options.handler' , $params->getParam('type'));
            $field = Field::factory($type , $params);

            return $field;
        }

    }
}
