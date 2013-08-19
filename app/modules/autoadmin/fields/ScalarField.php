<?php

namespace AutoAdmin\Fields;

use Phalcon\Tag;

class ScalarField extends Field
{

    public function beforeRender($params)
    {
        Tag::setDefault($params['id'], $params['value']);
    }

}