<?php
date_default_timezone_set('PRC');

// Configuration
if (is_file('config.php')) {
	require_once('config.php');
}

date_default_timezone_set('PRC');

// Define
define('THEME_PATH', 'assets/default/');

// Startup
require_once(DIR_SYSTEM . 'startup.php');

$application_config = 'catalog';

// Application
require_once(DIR_SYSTEM . 'framework.php');

