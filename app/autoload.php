<?php
session_start();
require_once(__DIR__ . "/router.php");
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/services/database.php");
require_once(__DIR__ . "/services/orm.php");
require_once(__DIR__ ."/models/cart.php");
require_once(__DIR__ ."/models/mailer.php");
require_once(__DIR__ ."/models/product.php");
require_once(__DIR__ ."/models/sale.php");
require_once(__DIR__ ."/models/user.php");
require_once(__DIR__ ."/models/seller.php");