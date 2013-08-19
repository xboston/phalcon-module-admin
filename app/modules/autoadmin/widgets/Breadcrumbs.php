<?php
namespace AutoAdmin\Widgets;

class Breadcrumbs extends Widget
{

    private $_path = [];

    public function add($label, $href)
    {

        $this->_path[] = [
            'label' => $label,
            'href'  => $href
        ];

        return $this;

    }

    protected function beforeRender()
    {

        $this->_view->setVar('path', $this->_path);

    }

}
