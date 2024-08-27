<?php
// session
session_start();

// router & config
require_once(__DIR__ . "/enviroment.php");
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/router.php");

// services
require_once(__DIR__ . "/services/database.php");
require_once(__DIR__ . "/services/orm.php");
require_once(__DIR__ . "/services/controller.php");

// models
require_once(__DIR__ . "/models/user.php");
require_once(__DIR__ . "/models/product.php");
require_once(__DIR__ . "/models/cart.php");
require_once(__DIR__ . "/models/mailer.php");
require_once(__DIR__ . "/models/order.php");
require_once(__DIR__ . "/models/calification.php");
require_once(__DIR__ . "/models/multimedia.php");
require_once(__DIR__ . "/models/withdraw.php");