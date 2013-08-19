<?php

trait Timestampable
{

    public function beforeCreate()
    {
        $this->created_at = date(DATE_ISO8601);
    }

    public function beforeUpdate()
    {
        $this->updated_at = date(DATE_ISO8601);
    }

}
