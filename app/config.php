<?php
$folderpath = dirname($_SERVER['SCRIPT_NAME']);
$urlpath = $_SERVER['REQUEST_URI'];
$url = substr($urlpath, strlen($folderpath));
date_default_timezone_set('America/Bogota');

define('URL_PATH', $urlpath);
define('URL', $url);
define('DOMAIN', getenv('DOMAIN'));

// Credenciales de Google
define('CLIENT_ID', getenv('CLIENT_ID'));
define('CLIENT_SECRET', getenv('CLIENT_SECRET'));
define('REDIRECT_URL', getenv('REDIRECT_URL'));

// Credenciales para la base de datos
define('DB_HOSTNAME', getenv('DB_HOSTNAME'));
define('DB_USERNAME', getenv('DB_USERNAME'));
define('DB_PASSWORD', getenv('DB_PASSWORD'));
define('DB_NAME',     getenv('DB_NAME'));

// Credenciales para API de Google Maps
define('API_MAPS', getenv('API_MAPS'));

// Credenciales de PayU
define('PAYU_REQUEST_URI',  getenv('PAYU_REQUEST_URI'));
define('PAYU_API_KEY',      getenv('PAYU_API_KEY'));
define('PAYU_MERCHANT_ID',  getenv('PAYU_MERCHANT_ID'));
define('PAYU_ACCOUNT_ID',   getenv('PAYU_ACCOUNT_ID'));
define('PAYU_TEST_MODE',    getenv('PAYU_TEST_MODE')); // 1 pruebas | 0

/*
CREDENCIALES PARA HACER TRANSACCIONES DE PRUEBA
APPROVED
4000123456789010 || 4509420000000008
777
3 / 25
*/