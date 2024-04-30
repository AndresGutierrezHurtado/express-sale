<?php
session_start();
require_once(__DIR__ . "/router.php");
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/services/database.php");
require_once(__DIR__ . "/services/orm.php");
require_once(__DIR__ . "/controllers/productController.php");
require_once(__DIR__ . "/controllers/userController.php");
require_once(__DIR__ . "/controllers/cartController.php");
require_once(__DIR__ . "/controllers/mailController.php");