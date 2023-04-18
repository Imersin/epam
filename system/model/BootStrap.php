<?php

namespace system;

class BootStrap
{
    public function __construct($aConfig)
    {
        try {
            \system\Registry::set('cfg', $aConfig);
            \system\Registry::set('db', new \system\Db($aConfig['db']));
            $oAutoUpdater = new \upd\AutoUpdater();
            $oAutoUpdater->update();
            session_start();
            $sClass = a($_GET, 'APP_PATH', '/work/home') . 'Action';
            $sClass = str_replace('/', '\\', $sClass);
            if (strpos($sClass, 'services') !== false) {
                $sClass = \work\ServicesFactory::create();
            }
            if (class_exists($sClass)) {
                $oAction = new $sClass();
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if ($oAction->canEdit()) {
                        $oAction->edit();
                    }
                    else {
                        require_once WWW_PATH. '/system/view/No_access.php';
                    }
                }
                else {
                    if ($oAction->canView()) {
                        $oAction->view();
                    }
                    else {
                        require_once WWW_PATH. '/system/view/No_access.php';
                    }
                }
            }
            else {
                http_response_code(404);
                require_once WWW_PATH. '/system/view/my_404.php';
                die();
            }

        }
        catch(\Exception $ex) {
            d($ex->getMessage() . $ex->getTraceAsString());
            \system\Logger::log($ex);
        }
    }
}