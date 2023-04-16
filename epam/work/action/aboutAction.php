<?php

namespace work;

class aboutAction extends \system\Action
{
    public $sViewPath = WWW_PATH . '/work/view/about.php';
    public function view()
    {
        require_once $this->sViewPath;
    }

    public function canView()
    {
        return true;
    }
}