<?php
$aConfig = [];
define('WWW_PATH', str_replace('\\', '/', __DIR__));
require_once 'config.php';
require_once 'functions.php';
function exceptions_error_handler($severity, $message, $filename, $lineno) {
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
}
set_error_handler('exceptions_error_handler');
spl_autoload_register(function ($class_name) {
    if (strpos($class_name, 'Action') !== false) {
        $iPos = strrpos($class_name, '\\') + 1;
        $class_name = substr($class_name, 0, $iPos) . 'action\\' . substr($class_name, $iPos);
    }
    else {
        $iPos = strrpos($class_name, '\\') + 1;
        $class_name = substr($class_name, 0, $iPos) . 'model\\' . substr($class_name, $iPos);
    }
    if (file_exists($class_name . '.php'))
        include $class_name . '.php';
});
new system\BootStrap($aConfig);
//$oDb = new system\Db($aConfig['db']);