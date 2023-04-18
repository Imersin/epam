<?php

namespace work;

class closeOperatorAction extends \system\Action
{

    public function view()
    {
        $oRequest = new \work\Request([], a($_REQUEST, 'request_id'));
        if ($oRequest->load()['status_id'] == 7) {
            $oRequest->update(['status_id' => 8]);
            print 1;
        }
        else {
            print "Пожалуйста, подождите пока клиент и бригада выполнят задачу";
        }
    }

    public function canView()
    {
        if (a($_SESSION, 'role_id') == 1)
            return true;
        return false;
    }

}