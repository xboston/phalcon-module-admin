<?php


namespace AutoAdmin\Widgets;

class Navbar extends Widget
{

    protected function beforeRender()
    {
        $navItems   = $this->getDI()->get('entityManager')->pluck('title');
        $active     = $this->dispatcher->getParam('entity');

        $this->_view->setVars([
            'navItems'  => $navItems,
            'active'    => $active
        ]);

    }
}
