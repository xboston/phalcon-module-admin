<?php

class SetCreatedAt extends \Phalcon\Mvc\User\Plugin
{

    /**
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\ModelInterface $model
     */
    public function beforeValidationOnCreate($event, &$model)
    {
        if ( ! $model->readAttribute('created_at')) {
            $model->writeAttribute('created_at', date('Y-m-d H:i:s'));
        }
    }

}