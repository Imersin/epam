<?php

namespace work;

class homeAction extends \system\Action
{
    public $sViewPath = WWW_PATH . '/work/view/home.php';
    public function view()
    {
        require_once $this->sViewPath;
    }

    public function canView()
    {
        return true;
    }
}