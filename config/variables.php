<?php

/**
  @author Simant Verma
 */

//Database configurations
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tekdi');

//paths
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'].'/tekdi/');
define('BASE_URL', 'http://'.$_SERVER['HTTP_HOST']);
define('SITE_URL', BASE_URL.'/tekdi/');
define('APP_URL', SITE_URL.'app/');

//site urls
define('IMAGE_PATH', APP_URL.'images/');
define('CSS_PATH', APP_URL.'css/');
define('JS_PATH', APP_URL.'js/');
define('TEMPLATES', BASE_PATH.'app/templates/');
define('VIEWS', BASE_PATH.'app/views/');

//others
define('PS', 'yh345ks#dssm78yer');

//valid PHP
define('_VALID_PHP', '1');

require_once BASE_PATH.'Cl/Tbox.php';
require_once BASE_PATH.'Cl/utils.php';
require_once BASE_PATH.'Cl/security.php';