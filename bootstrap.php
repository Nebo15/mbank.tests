<?php
require_once dirname(__FILE__).'/vendor/autoload.php';

date_default_timezone_set('Etc/GMT+2');

define("APP_ENV", 'web');

if (APP_ENV == 'web')
{
    define("APP_PATH", '/Users/evgenfurman/Mbankwebmobile.app.zip');

} elseif (APP_ENV == 'ios')
{
    define("APP_PATH", '/Users/evgenfurman/MBank.app.zip');
}

if (!APP_PATH) {
    die("App did not exist!");
}
