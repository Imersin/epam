<?php

namespace upd;

class AutoUpdater
{
     public function __construct()
     {

     }

     public function update() {
         $aFiles = scandir(WWW_PATH . '/upd/model/updates');
         foreach ($aFiles as $sFile) {
             if (strpos($sFile, 'upd') !== false && !file_exists(WWW_PATH . '/upd/updates_executed/' . substr($sFile, 0, -4))) {
                $sFilePath = WWW_PATH . '\upd\model\updates\\' . $sFile;
                $sFile = str_replace('.php', '', $sFile);
                require_once $sFilePath;
                $o = new $sFile();
                try {
                    fopen(WWW_PATH . '/upd/updates_executed/' . $sFile, "w");
                    $o->execute();
                }
                catch (\Exception $ex) {
                    d($ex->getMessage() . $ex->getTraceAsString());
                }
             }
         }
     }
}