<?php
$folderpath = dirname($_SERVER['SCRIPT_NAME']);
$urlpath = $_SERVER['REQUEST_URI'];
$url = substr($urlpath, strlen($folderpath));
date_default_timezone_set('America/Bogota');

define('URL_PATH', $urlpath);
define('URL', $url);
define('DOMAIN', $_ENV['DOMAIN'] );

// Credenciales de Google
define('CLIENT_ID', $_ENV['CLIENT_ID'] );
define('CLIENT_SECRET', $_ENV['CLIENT_SECRET'] );
define('REDIRECT_URL', $_ENV['REDIRECT_URL'] );

// Credenciales para la base de datos
define('DB_HOSTNAME', $_ENV['DB_HOSTNAME'] );
define('DB_USERNAME', $_ENV['DB_USERNAME'] );
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] );
define('DB_NAME',     $_ENV['DB_NAME'] );

// Credenciales para API de Google Maps
define('API_MAPS', $_ENV['API_MAPS'] );

// Credenciales de PayU
define('PAYU_REQUEST_URI',  $_ENV['PAYU_REQUEST_URI'] );
define('PAYU_API_KEY',      $_ENV['PAYU_API_KEY'] );
define('PAYU_MERCHANT_ID',  $_ENV['PAYU_MERCHANT_ID'] );
define('PAYU_ACCOUNT_ID',   $_ENV['PAYU_ACCOUNT_ID'] );
define('PAYU_TEST_MODE',    $_ENV['PAYU_TEST_MODE']); // 1 pruebas | 0

/*
CREDENCIALES PARA HACER TRANSACCIONES DE PRUEBA
APPROVED
4000123456789010 || 4509420000000008
777
3 / 25
*/