<?php
$folderpath = dirname($_SERVER['SCRIPT_NAME']);
$urlpath = $_SERVER['REQUEST_URI'];
$url = substr($urlpath, strlen($folderpath));

define('FOLDER_PATH', $folderpath);
define('URL_PATH', $urlpath);
define('URL', $url);
