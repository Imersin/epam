<?php

namespace work;

class closeWorkerAction extends \system\Action
{

    public function view()
    {
        $oRequest = new \work\Request([], a($_REQUEST, 'request_id'));
        if ($oRequest->load()['status_id'] == 2) {
            if (a($_REQUEST, 'type') == 'accept') {
                $oRequest->update(['status_id' => 3]);
                \work\Util::makeWorkerBusy(a($_SESSION, 'user_id'));
            }
            else if (a($_REQUEST, 'type') == 'reject') {
                $oRequest->update(['status_id' => 4]);
                \work\Util::checkWorkerFree(a($_SESSION, 'user_id'));
            }
            else {
                print "Выберите действие";
                die();
            }
            print 1;
            die();
        }
        if ($oRequest->load()['status_id'] == 3) {
            $oRequest->update(['status_id' => 5]);
            \work\Util::checkWorkerFree(a($_SESSION, 'user_id'));
            print 1;
        }
        else {
            print "Вы можете отметить задачу как выполненную, только если она находится на исполнении";
        }
    }

    public function canView()
    {
        if (a($_SESSION, 'role_id') == 2)
            return true;
        return false;
    }

}