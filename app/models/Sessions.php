<?php


class Sessions extends \Phalcon\Mvc\Model 
{

    /**
     * @var integer
     *
     */
    public $id;

    /**
     * @var integer
     *
     */
    public $user_id;

    /**
     * @var string
     *
     */
    public $user_agent;

    /**
     * @var string
     *
     */
    public $token;

    /**
     * @var integer
     *
     */
    public $expires;

    /**
     * @var integer
     *
     */
    public $created;

    public function initialize()
    {
        $this->belongsTo('user_id', 'Users', 'id');
    }

}
