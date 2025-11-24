<?php
// Bootstrap file
session_start();

$config = require __DIR__ . '/config.php';
if (file_exists(__DIR__ . '/config.local.php')) {
    $local = require __DIR__ . '/config.local.php';
    $config = array_merge($config, $local);
}

// Simple autoload
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../src/' . $class . '.php';
    if (file_exists($path)) {
        require $path;
    }
});

// Database instance accessible via $db
$db = new Database($config['db_host'], $config['db_name'], $config['db_user'], $config['db_pass']);
$auth = new Auth($db);
