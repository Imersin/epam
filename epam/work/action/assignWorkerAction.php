<?php

namespace work;

class assignWorkerAction extends \system\Action
{

    public function view()
    {
        $oRequest = new \work\Request([], a($_REQUEST, 'request_id'));
        $oRequest->update(['worker_id' => a($_REQUEST, 'worker_id'), 'status_id' => 2, 'operator_id' => $_SESSION['user_id']]);
        \work\Util::makeWorkerBusy(a($_REQUEST, 'worker_id'));
    }

    public function canView()
    {
        if (a($_SESSION, 'role_id') == 1)
            return true;
        return false;
    }

}