<?php
$folderpath = dirname($_SERVER['SCRIPT_NAME']);
$urlpath = $_SERVER['REQUEST_URI'];
$url = substr($urlpath, strlen($folderpath));

define('URL_PATH', $urlpath);
define('URL', $url);

define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'express-sale-bd');

define('API_MAPS', 'AIzaSyACEoqwUojmSsTZX_zMVHRZVDkAoBharV0');

/*
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'id22105035_expresssale');
define('DB_PASSWORD', 'Exsl.2024');
define('DB_NAME', 'id22105035_express_sale_db');
*/