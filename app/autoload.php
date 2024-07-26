<?php
// session
session_start();

// router & config
require_once(__DIR__ . "/router.php");
require_once(__DIR__ . "/config.php");

// services
require_once(__DIR__ . "/services/database.php");
require_once(__DIR__ . "/services/orm.php");

// models
require_once(__DIR__ . "/models/user.php");
require_once(__DIR__ . "/models/product.php");
require_once(__DIR__ . "/models/cart.php");
require_once(__DIR__ . "/models/mailer.php");
require_once(__DIR__ . "/models/order.php");
require_once(__DIR__ . "/models/calification.php");