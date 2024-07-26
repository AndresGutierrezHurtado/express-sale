<?php
$folderpath = dirname($_SERVER['SCRIPT_NAME']);
$urlpath = $_SERVER['REQUEST_URI'];
$url = substr($urlpath, strlen($folderpath));

define('URL_PATH', $urlpath);
define('URL', $url);
define('DOMAIN', 'http://localhost:3000');

define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'express-sale-bd');

define('API_MAPS', 'AIzaSyACEoqwUojmSsTZX_zMVHRZVDkAoBharV0');

define('PAYU_REQUEST_URI', 'https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/');
define('PAYU_API_KEY', '4Vj8eK4rloUd272L48hsrarnUA');
define('PAYU_MERCHANT_ID', '508029');
define('PAYU_ACCOUNT_ID', '512321');
define('PAYU_TEST_MODE', '1');  // 1 pruebas | 0 producción

/*
CREDENCIALES PARA HACER TRANSACCIONES DE PRUEBA
APPROVED
4000123456789010
777
3 / 25

CREDENCIALES PARA PRODUCCIÓN
define('PAYU_REQUEST_URI', 'https://checkout.payulatam.com/ppp-web-gateway-payu');
define('PAYU_API_KEY', 'yKCKj7p1K1xeM1CtR8sLtF1pcM');
define('PAYU_MERCHANT_ID', '999993');
define('PAYU_ACCOUNT_ID', '1008657');
define('PAYU_TEST_MODE', '0'); // 1 pruebas | 0 producción 
define('DOMAIN', 'https://express-sale-2024.000webhostapp.com');

define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'id22105035_expresssale');
define('DB_PASSWORD', 'Exsl.2024');
define('DB_NAME', 'id22105035_express_sale_db');
*/