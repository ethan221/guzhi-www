<?php
// HTTP
define('HTTP_SERVER', 'http://'.$_SERVER['SERVER_NAME'].'/admin/');
define('HTTP_CATALOG', 'http://'.$_SERVER['SERVER_NAME'].'/');

// HTTPS
define('HTTPS_SERVER', 'http://www.edgteam.cn/admin/');
define('HTTPS_CATALOG', 'http://www.edgteam.cn/');

// DIR
define('APP_PATH', getcwd().'/../');
define('DIR_APPLICATION',APP_PATH.'admin/');
define('DIR_SYSTEM',APP_PATH.'system/');
define('DIR_IMAGE',APP_PATH.'image/');
define('DIR_LANGUAGE',APP_PATH.'admin/language/');
define('DIR_TEMPLATE',APP_PATH.'admin/view/template/');
define('DIR_CONFIG',APP_PATH.'system/config/');
define('DIR_CACHE',APP_PATH.'system/storage/cache/');
define('DIR_DOWNLOAD',APP_PATH.'system/storage/download/');
define('DIR_LOGS',APP_PATH.'system/storage/logs/');
define('DIR_MODIFICATION',APP_PATH.'system/storage/modification/');
define('DIR_UPLOAD',APP_PATH.'system/storage/upload/');
define('DIR_CATALOG',APP_PATH.'catalog/');

// DB
/*
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'edg.yundb@test');
define('DB_DATABASE', 'edg_cart');
define('DB_PORT', '3306');
define('DB_PREFIX', 'mcc_');
*/

define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'mycncart');
define('DB_PORT', '3306');
define('DB_PREFIX', 'mcc_');