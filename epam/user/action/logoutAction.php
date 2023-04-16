<?php

namespace user;

class logoutAction extends \system\Action
{
    public $oLoginModel;

    public function canEdit()
    {
        return true;
    }

    public function edit()
    {
        $this->oLoginModel = new \user\LoginModel();
        $this->oLoginModel->logout();
    }
}