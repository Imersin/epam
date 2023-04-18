<?php

namespace user;

class registrationAction extends \system\Action
{
    public $oLoginModel;

    public function __construct()
    {
        parent::__construct();
    }

    public function canEdit()
    {
        return true;
    }

    public function edit()
    {
        $this->oLoginModel = new \user\LoginModel();
        $iStatus = $this->oLoginModel->register($_POST['email'], $_POST['pwd'], $_POST['name'], $_POST['address'], $_POST['telephone'], $_POST['login']);
        print $iStatus;
    }
}