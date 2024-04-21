<?php
$folderpath = dirname($_SERVER['SCRIPT_NAME']);
$urlpath = $_SERVER['REQUEST_URI'];
$url = substr($urlpath, strlen($folderpath));

define('URL', $url);
define('URL_PATH', $urlpath);
