<?php


/**
 * Class Model
 * @package Bitfalls\Phalcon
 */
class BaseModel extends \Phalcon\Mvc\Model
{

    /** @var string */
    protected $entity_type;

    /**
     * Типичные базовые настойки инициализации моделей
     */
    public function initialize()
    {
        $this->keepSnapshots(false);
        $this->useDynamicUpdate(true);
    }

    /**
     * Вывод списка сообщений ошибок в строку
     *
     * @param bool $asString
     *
     * @return \Phalcon\Mvc\Model\MessageInterface[]|string
     */
    public function getMessages($asString = false)
    {
        if ( !$asString ) {
            return parent::getMessages();
        } else {
            return implode(', ' , parent::getMessages());
        }
    }

}
