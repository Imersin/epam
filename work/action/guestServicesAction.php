<?php

namespace work;

class guestServicesAction extends \system\Action
{
    public $sViewPath = WWW_PATH . '/work/view/services.php';
    public function view()
    {
        require_once $this->sViewPath;
    }

    public function canView()
    {
        return true;
    }
}