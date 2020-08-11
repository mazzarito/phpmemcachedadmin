<?php
# Headers
header('Content-type: text/html;');
header('Cache-Control: no-cache, must-revalidate');

# Constants declaration
define('CURRENT_VERSION', '1.3.0');

# PHP < 5.3 Compatibility
if (defined('ENT_IGNORE') === false) {
    define('ENT_IGNORE', 0);
}

# XSS / User input check
if(isset($_REQUEST) && is_array($_REQUEST)) {
  $filter = function (&$array) use (&$filter) {
    foreach ($array as &$item) {
      if (is_array($item)) {
        $filter($item);
      }
      else {
        $item = htmlentities($item);
      }
    }
  };
  
  $filter($_REQUEST);
}

# Autoloader
function autoloader($class)
{
    require_once str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
}
spl_autoload_register('autoloader');

# Loading ini file
$_ini = Library_Configuration_Loader::singleton();

# Date timezone
date_default_timezone_set('Europe/Paris');
