<?php
require_once dirname(__FILE__).'/vendor/autoload.php';

date_default_timezone_set('Etc/GMT+2');

define("APP_ENV", 'ios');
define("ENVIRONMENT", 'DEV');

if (APP_ENV == 'web' && ENVIRONMENT == 'DEV')
{
    define("APP_PATH", '/Users/evgenfurman/BestWallet.app');

} elseif (APP_ENV == 'ios' && ENVIRONMENT == 'STG')
{
    define("APP_PATH", '/Users/evgenfurman/STGMBank.app.zip');

} elseif (APP_ENV == 'ios' && ENVIRONMENT == 'DEV')
{
    define("APP_PATH", '/Users/evgenfurman/MBank.app.zip');
}

if (!APP_PATH) {
    die("App did not exist!");
}
