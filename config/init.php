<?php
/**
 * User: gabix
 * Date: 26/10/12
 * Time: 14:12
 */
define('APP_ROOT', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);

require_once APP_ROOT.DS.'config'.DS.'localhost.php';
//require_once APP_ROOT.DS.'config'.DS.'zymic.php';

require_once APP_ROOT.DS.'cls'.DS.'dbFuncs.php';
require_once APP_ROOT.DS.'cls'.DS.'SuperFuncs.php';

dbFuncs::crearTablaCiudades();
