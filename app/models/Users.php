<?php

use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Mvc\Model\Validator\PresenceOf as EmptyValidator;


class Users extends \Phalcon\Mvc\Model
{

    /**
     * @Primary
     * @FormField(type: hidden)
     * @TableField(type: text, label: id, options: { sortable: true })
     * @var integer
     */
    public $id;

    /**
     * @Title
     * @Field(type: text, label: 'Логин')
     * @FormField()
     * @TableField(options: { layout: link })
     * @var string
     */
    public $username;

    /**
     * @Field(type: text, label: 'E-mail')
     * @FormField()
     * @var string
     */
    public $email;

    /**
     * @Field(type: password, label: 'Пароль')
     * @FormField()
     * @var string
     */
    public $password;

    /**
     * @SelectField(label: 'Права', source: array, options: ['admins' = 'Админ', 'users' = 'Пользователь'], using: [id, name])
     * @var string
     */
    public $role;


    /**
    * @FormField(type: select, label: 'Опубликован', tag: { source: array, options: ['Нет', 'Да'] })
    * @var integer
    */
    public $active;

    /**
     * @Field(type: text, label: 'Имя')
     * @FormField()
     * @TableField()
     * @var string
     */
    public $name;


    /** @var string */
    public $last_login;

    /**
     * @Field(label: 'Дата создания', type: datetime)
     * @FormField(tag: { disabled: disabled })
     * @TableField()
     * @var string
     */
    public $created_at;

    public function initialize()
    {
        $this->useDynamicUpdate(true);
    }

    /**
     * @return bool
     */
    public function validation()
    {
        $this->validate(new EmptyValidator(array(
            'field'   => 'username',
            'message' => 'Пожалуйста, укажите Ваше имя'
        )));

        $this->validate(new EmptyValidator(array(
            'field'   => 'email',
            'message' => 'Пожалуйста, укажите корректный адрес электронной почты'
        )));

        $this->validate(new EmailValidator(array(
            'field'   => 'email',
            'message' => 'Пожалуйста, проверьте корректность указанного адреса электронной почты'
        )));

        $this->validate(new EmptyValidator(array(
            'field'   => 'password',
            'message' => 'Необходимо ввести пароль'
        )));

        if (empty($this->id)) {
            $this->validate(new UniquenessValidator(array(
                'field'   => 'email',
                'message' => 'На этот почтовый адрес уже зарегистрирована учётная запись.'
            )));
        } else {
            $this->validate(new UniquenessValidator(array(
                'field'   => 'email',
                'message' => 'На этот почтовый адрес уже зарегистрирована учётная запись'
            )));
        }

        return $this->validationHasFailed() != true;
    }

}
