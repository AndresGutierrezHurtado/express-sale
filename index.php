<?php
require_once(__DIR__ . "/app/router.php");
require_once(__DIR__ . "/app/config.php");

$router = new Router();
$router->run();