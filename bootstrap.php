<?php
require_once dirname(__FILE__).'/vendor/autoload.php';

date_default_timezone_set('Etc/GMT+2');

define("APP_PATH", '/Users/andrew/Library/Developer/Xcode/DerivedData/MBank-afgwujrjtnidxocxzbrkmezaylxu/Build/Products/Debug-iphonesimulator/MBank.app');

if (!APP_PATH) {
    die("App did not exist!");
}
