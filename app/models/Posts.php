<?php


class Posts extends \BaseModel
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
     * @Field(type: text, label: 'Заголовок', tag: {class: 'input-lg', maxlength: 25 })
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
     * @FormField(type: textArea, label: 'Описание', editor: true )
     * @var string
     */
    public $description;

    /**
     * @FormField(type: textArea, label: 'RAW HTML', editor: false )
     * @var string
     */
    public $html;

    /**
     * @FormField(type: textArea, label: 'RAW HTML', editor: false )
     * @var string
     */
    public $css;

    /**
     * @FormField(type: textArea, label: 'RAW HTML', editor: false )
     * @var string
     */
    public $js;

    /**
     * @Field(label: 'Дата создания', type: datetime)
     * @FormField(tag: { disabled: disabled })
     * @TableField()
     * @var string
     */
    public $created;

    /**
     * @FormField(type: text, label: 'Автор')
     * @var string
     */
    public $author;

    /**
     * @FormField(type: select, label: 'Категория', tag: { source: model, model: '\Categories', using: [id, title] })
     * @var integer
     */
    public $category;

    /**
     * @FormField(type: select, label: 'Опубликовано', tag: { source: array, options: ['Нет', 'Да'] })
     * @var integer
     */
    public $status;

    /**
     * @FormField(type: select, label: 'Опубликовано', tag: { source: array, options: ['Нет', 'Да'] })
     * @var integer
     */
    public $comments;

}
