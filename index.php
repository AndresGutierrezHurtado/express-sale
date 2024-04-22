<?php
require_once(__DIR__ . "/app/autoload.php");
require_once(__DIR__ . "/app/controllers/productController.php");
require_once(__DIR__ . "/app/controllers/userController.php");

$router = new Router();
$router->run();