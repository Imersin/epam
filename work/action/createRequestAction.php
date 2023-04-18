<?php

namespace work;

class createRequestAction extends \system\Action
{

    public $aPackage;

    public function __construct()
    {
        $this->aPackage = json_decode(a($_REQUEST, 'data', []), true);
    }

    public function view()
    {
        if (!isset($this->aPackage['description'])) {
            print "Заполните описание";
            die();
        }
        if (!isset($this->aPackage['request_type_id'])) {
            print "Заполните тип работ";
            die();
        }
        $this->aPackage['description'] = '\'' . $this->aPackage['description'] . '\'';
        $this->aPackage['open_date'] = '\'' . date("Y-m-d H:i:s")  . '\'';
        $this->aPackage['user_id'] = $_SESSION['user_id'];
        $this->aPackage['status_id'] = 1;
        $oRequest = new \work\Request($this->aPackage);
        $oRequest->save();
        print 1;
    }

    public function canView()
    {
        if (a($_SESSION, 'role_id') == 3) {
            return true;
        }
        return false;
    }
}