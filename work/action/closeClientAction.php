<?php

namespace work;

class closeClientAction extends \system\Action
{

    public function view()
    {
        $oRequest = new \work\Request([], a($_REQUEST, 'request_id'));
        if ($oRequest->load()['status_id'] == 5) {
            if (a($_REQUEST, 'type') == 'accept') {
                $oRequest->update(['status_id' => 7]);
            }
            else {
                $oRequest->update(['status_id' => 6]);
            }
            print 1;
        }
        else {
            print "Вы можете отметить задачу как выполненную, только если бригада отметит ее как выполненную";
        }
    }

    public function canView()
    {
        if (a($_SESSION, 'role_id') == 3)
            return true;
        return false;
    }

}