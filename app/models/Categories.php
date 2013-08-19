<?php


class Categories extends \BaseModel
{

    use Slugable;

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
    public $title;

    /**
     * @FormField(type: text, label: 'Псевдоним', tag: { disabled: disabled })
     * @var string
     */
    public $slug;

    /**
     * @FormField(type: textarea, label: 'Описание', editor: false )
     * @var string
     */
    public $description;

}
