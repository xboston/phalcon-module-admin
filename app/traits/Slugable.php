<?php

trait Slugable
{

    public function beforeCreate()
    {
        $this->slug = \Phalcon\Tag::friendlyTitle($this->title);
    }

    public function beforeUpdate()
    {
        $this->slug = \Phalcon\Tag::friendlyTitle($this->title);
    }

}
