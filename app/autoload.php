<?php
// session
session_start();

$envPath = (__DIR__ . '/../.env');

if (file_exists($envPath)) {
    $envFile = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envFile as $line) {
        if (strpos(trim($line), '#') === 0 || empty($line)) continue;

        list($key, $value) = explode('=', $line, 2);

        $key = trim($key);
        $value = trim($value);

        if (function_exists('putenv')) {
            putenv("$key=$value");
        } else {
            $_ENV[$key] = $value;
        }

        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

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
require_once(__DIR__ . "/models/multimedia.php");