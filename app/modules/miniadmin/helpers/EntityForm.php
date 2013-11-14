<?php

namespace MiniAdmin\Helpers {

    use Phalcon\Forms\Form , \Phalcon\Forms\Element\Submit as Submit;

    class EntityForm extends Form
    {

        public $fields = [ ];
        private $classPrefix = '\\Phalcon\\Forms\\Element\\';
        public $action;


        /**
         * @param $model
         * @param $action
         */
        public function initialize($model , $action = false)
        {

            $this->action = $action;

            //Заполняем поля формы данными из модели
            $object = $model;
            $this->setEntity($object);

            //Получаем атрибуты модели
            $attributes = $this->modelsMetadata->getAttributes($object);

            // Получаем аннотации из модели
            $metadata = $this->annotations->get($object);

            // Считыаем аннотацию @FormField
            foreach ( $attributes as $attribute ) {

                $this->fields[$attribute] = $metadata->getPropertiesAnnotations()[$attribute]->get('FormField')->getArguments();
            }

            // Создаем поля формы с учетом видимости
            foreach ( $this->fields as $field => $types ) {

                //$fieldType  = array_shift($types); // атрибут type в аннотации нам более не нужен

                if ( !isset($types['type']) ) {

                    continue;
                }

                // выпадающие списки пропускаем, для них надо настраивать мета-связи
                if ( $types['type'] == 'select' ) {

                    continue;
                }

                $fieldType = $types['type'];

                $fieldClass = $this->classPrefix . $fieldType;

                $this->add(new $fieldClass($field , $types));

                //устанавливаем label если поле не скрыто
                if ( strtolower($fieldType) !== 'hidden' ) {

                    $label = isset($types['label']) ? $types['label'] : $this->get($field)->getName();
                    $this->get($field)->setLabel($label);
                }
            }

            // Добавляем кнопку отправки
            $this->add(
                new Submit('submit' , [
                                      'value' => 'Send' ,
                                      ])
            );
        }

        public function renderform()
        {
            echo $this->tag->form(
                [
                $this->action ,
                'id' => 'actorform' ,
                ]
            );

            echo "\n";

            foreach ( $this as $element ) {

                /** @var $element \Phalcon\Forms\Element */


                $messages = $this->getMessagesFor($element->getName());
                if ( count($messages) ) {

                    echo '<div class="messages">' . "\n";
                    foreach ( $messages as $message ) {
                        echo $message . "\n";
                    }
                    echo '</div>' . "\n";

                }

                echo "\t" . '<div>' . "\n";
                echo($element->getLabel() ? ("\t\t" . '<label for="' . $element->getName() . '">' . $element->getLabel() . '</label>' . "\t\t\n") : '');
                //var_dump($element);
                echo "\t\t" . $element . "\n";
                echo "\t" . '</div>' . "\n";

            }

            echo $this->tag->endForm();
        }
    }
}
