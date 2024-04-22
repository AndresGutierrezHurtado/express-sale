<?php
$folderpath = dirname($_SERVER['SCRIPT_NAME']);
$urlpath = $_SERVER['REQUEST_URI'];
$url = substr($urlpath, strlen($folderpath));

define('URL_PATH', $urlpath);
define('URL', $url);

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'express-sale-db');