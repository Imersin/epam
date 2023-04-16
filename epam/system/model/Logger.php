<?php

namespace system;

class Logger
{
    public static function log(\Exception $oE)
    {
        $sFilePath = vsprintf(
            '%s/%s.log', array(
                \system\Registry::get('cfg')['app_log_path'],
                date('Ymd')
            )
        );
        $sString = date('Y-m-d H:i:s') . " " . $oE->getMessage() . $oE->getTraceAsString();
        $sString =  trim(preg_replace('/\s+/', ' ', $sString));
        $sString .= PHP_EOL;
        file_put_contents($sFilePath, $sString, FILE_APPEND);
    }
}