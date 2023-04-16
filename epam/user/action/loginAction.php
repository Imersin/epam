<?php

namespace user;

class loginAction extends \system\Action
{
    public $oLoginModel;

    public function canEdit()
    {
        return true;
    }

    public function edit()
    {
        $this->oLoginModel = new \user\LoginModel();
        $iStatus = $this->oLoginModel->login($_POST['email'], $_POST['pwd']);
        print $iStatus;
    }
}