<?php
error_reporting(E_ALL & ~E_DEPRECATED);

define('PATH_ROOT',      dirname(__FILE__) . '/../');
define('PATH_WWW',       'http://localhost/vih/hojskole/src/vih.dk/');
define('DB_USER',        'root');
define('DB_PASSWORD',    '');
define('DB_NAME',        'vih');
define('DB_HOST',        'localhost');
define('DB_DSN',         'mysql://' . DB_USER . ':' . DB_PASSWORD . '@' . DB_HOST . '/' . DB_NAME);
define('SECURE_SERVER_STATUS',    'offline');
define('PATH_UPLOAD', PATH_ROOT . 'upload/');
define('PATH_UPLOAD_ORIGINAL', PATH_UPLOAD . 'devel/original/');
define('PATH_UPLOAD_INSTANCE', PATH_UPLOAD . 'devel/instance/');
define('PATH_UPLOAD_TEMPORARY', 'temp/');
define('IMAGE_POPUP_SIZE', 'medium');
define('FILE_VIEWER', '/hojskole/src/vih.dk/file.php');

set_include_path('.' . PATH_SEPARATOR . PATH_ROOT . PATH_SEPARATOR . get_include_path());

$GLOBALS['error_log_file'] = '/home/lsolesen/tmp/vih.error.log';

ini_set('session.use_trans_sid', '0');

putenv('TZ=Europe/Copenhagen');
setlocale(LC_ALL, 'da_DK.ISO8859-1');
