<?php

namespace user;

class createUserAction extends \system\Action
{
    public $oLoginModel;

    public function canEdit()
    {
        return a($_SESSION, 'role_id') == 1;
    }

    public function edit()
    {
        $this->oLoginModel = new \user\LoginModel();
        $iStatus = $this->oLoginModel->createUser($_POST['fullname'], $_POST['email'], $_POST['pwd'], $_POST['role_id']);
        print $iStatus;
    }

}