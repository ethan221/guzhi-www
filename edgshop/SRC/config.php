<?php
// HTTP
// define('HTTP_SERVER', 'http://edgcart.test/');
define('HTTP_SERVER', 'http://'.$_SERVER['SERVER_NAME'].'/');

// HTTPS
//define('HTTPS_SERVER', 'https://edgcart.test/');
define('HTTPS_SERVER',  'http://'.$_SERVER['SERVER_NAME'].'/');

// DIR
define('APP_PATH', getcwd().'/');
define('DIR_APPLICATION', APP_PATH. 'catalog/');
define('DIR_SYSTEM', APP_PATH.'system/');
define('DIR_IMAGE', APP_PATH.'image/');
define('DIR_LANGUAGE', APP_PATH.'catalog/language/');
define('DIR_TEMPLATE', APP_PATH.'catalog/view/theme/');
define('DIR_CONFIG', APP_PATH.'system/config/');
define('DIR_CACHE', APP_PATH.'system/storage/cache/');
define('DIR_DOWNLOAD', APP_PATH.'system/storage/download/');
define('DIR_LOGS', APP_PATH.'system/storage/logs/');
define('DIR_MODIFICATION', APP_PATH.'system/storage/modification/');
define('DIR_UPLOAD', APP_PATH.'system/storage/upload/');

// DB
//define('DB_DRIVER', 'mysqli');
//define('DB_HOSTNAME', '120.24.173.74');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', 'Edgyundb@utc_2016');
//define('DB_DATABASE', 'edg_cart');
//define('DB_PORT', '3306');
//define('DB_PREFIX', 'mcc_');

define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'mycncart');
define('DB_PORT', '3306');
define('DB_PREFIX', 'mcc_');

define('DB_SETTING', serialize(
        array(
                'default' => array(
                        'driver' => 'mysqli',
                        'host' => '120.24.173.74',
                        'username' => 'root',
                        'password' => 'Edgyundb@utc_2016',
                        'database' => 'edg_cart',
                        'db_port'   => '3306',
                        'prefix' => 'mcc_'
                ),
                'read' => array(
                        'driver' => 'mysqli',
                        'host'  => '120.24.173.74',
                        'username' => 'root',
                        'password' => 'Edgyundb@utc_2016',
                        'database' => 'edg_cart',
                        'db_port' => '3306',
                        'prefix'    => 'mcc_'
                )
         )
        ));//数据库配置信息
