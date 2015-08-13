<?php
$base_dir = dirname(__FILE__);
require_once $base_dir.'/vendor/autoload.php';
require_once $base_dir.'/bootstrap.override.php';

date_default_timezone_set('Etc/GMT+2');

define("APP_ENVIRONMENT", $config['environment']);
define("APP_PLATFORM", $config['platform']);
define("APP_PATH", $config['environments'][APP_PLATFORM][APP_ENVIRONMENT]);

// Remove this two lines:
define("ENVIRONMENT", APP_PLATFORM);
define("APP_ENV", APP_ENVIRONMENT);

if (!APP_PATH || !file_exists(APP_PATH)) {
    echo APP_PATH;
    die("App did not exist!");
}
