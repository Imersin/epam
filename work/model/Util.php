<?php

namespace work;

class Util
{
    public static function makeWorkerBusy($sId){
        \system\Registry::get('db')
            ->add('UPDATE users SET worker_status = 1 WHERE id = ?')->execute([$sId]);
    }

    public static function checkWorkerFree($sId){
        $aRes = \system\Registry::get('db')
            ->add('SELECT COUNT(*) FROM client_requests WHERE id = ? AND status_id = 3')->execute([$sId])->fetchAll();
        if ($aRes[0]['count'] == 0) {
            \system\Registry::get('db')
                ->add('UPDATE users SET worker_status = 0 WHERE id = ?')->execute([$sId]);
        }
    }
}