<?php


class Full extends \Phalcon\Mvc\Model
{

    use \Timestampable;

    /**
     * @Primary
     * @FormField(type: hidden)
     * @TableField(type: text, label: id, options: { sortable: true })
     * @var integer
     */
    public $id;

    /**
     * @Title
     * @Field(type: text, label: 'String')
     * @FormField()
     * @TableField(options: { layout: link })
     * @var string
     */
    public $title;

    /**
     * @Title
     * @Field(type: text, label: 'Slug String')
     * @FormField()
     * @var string
     */
    public $slug;

    /**
     * @FormField(type: textArea, label: 'Text + editor', editor: true)
     * @var string
     */
    public $description;

    /**
     * @FormField(type: textArea, label: 'Text', editor: false )
     * @var string
     */
    public $raw_html;

    /**
     * @Primary
     * @FormField(type: number, label: 'Big Integer', min: 10, max: 15, size: 500)
     * @var integer
     */
    public $field_bigint;

    /**
     * @Primary
     * @FormField(type: email, label: 'Email')
     * @var integer
     */
    public $email;

    /**
     * @Primary
     * @FormField(type: text, label: 'Time')
     * @var integer
     */
    public $field_time;

    /**
     * @Primary
     * @FormField(type: date, label: 'Date')
     * @var integer
     */
    public $field_date;

    /**
     * @Primary
     * @FormField(type: text, label: 'Boolean', value: 'Y', checked: false)
     * @var integer
     */
    public $field_boolean;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

}
