<?php

// Poner .env a la hora de ir a producción
$envPath = (__DIR__ . '/../.env.example'); 

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