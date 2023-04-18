<?php

namespace work;

class workerServicesAction extends \system\Action
{
    public $iPage;
    public $sType;
    public $bPartial;
    public $aAll = [];

    public function __construct()
    {
        $this->iPage = a($_REQUEST, 'page', 1);
        $this->sType = a($_REQUEST, 'type', 'everything');
        $this->bPartial = a($_REQUEST, 'part', false);
        $this->aAll = [
            'myActive' => ['worker_id = ' . $_SESSION['user_id'], '(status_id = 2 OR status_id = 3 OR status_id = 5)'],
            'myClosed' => ['worker_id = ' . $_SESSION['user_id'], '(status_id = 4 OR status_id = 6 OR status_id = 7 OR status_id = 8)']
        ];
    }

    public function view()
    {
        $oGrid = new \work\Grid('client_requests');
        if ($this->sType != 'everything') {
            $this->aAll = array_intersect_key($this->aAll, [$this->sType => 123]);
        }
        $oGrid->addColumn('client_requests.id AS request_id');
        $oGrid->addColumn('users.fullname AS client_name');
        $oGrid->addColumn('client_requests.request_type_id AS request_type_id');
        $oGrid->addColumn('client_requests.description AS description');
        $oGrid->addColumn('client_requests.open_date AS date');
        $oGrid->addColumn('x.fullname AS worker_name');
        $oGrid->addColumn('client_requests.close_date AS close_date');
        $oGrid->addColumn('client_requests.status_id AS status_id');
        $oGrid->setJoin('LEFT JOIN users ON client_requests.user_id = users.id LEFT JOIN users x ON client_requests.worker_id = x.id');
        foreach ($this->aAll as $sType => $aCond) {
            if ($this->bPartial) {
                $oGrid->setPage($this->iPage);
            }
            else {
                $oGrid->setPage(1);
            }
            foreach ($aCond as $sCond) {
                $oGrid->addCondition($sCond);
            }
            $aData[$sType]['data'] = $oGrid->getData();
            $aData[$sType]['page'] = $oGrid->getPage();
            $oGrid->clearConditions();
        }
        if (!$this->bPartial) {
            require_once WWW_PATH . '/work/view/worker.php';
        }
        else {
            print json_encode($aData);
        }
    }

    public function canView()
    {
        if (a($_SESSION, 'role_id') != 2) {
            header("Location: /work/home");
        }
        return true;
    }
}