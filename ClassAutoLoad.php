<?php

require 'config/config.php';
$conn = require 'config/db_conn.php';

$directory = array('Global', 'layouts', 'forms', 'config', 'tables');

spl_autoload_register(function ($className) use ($directory) {
    foreach ($directory as $dir) {
        $file = $dir . '/' . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    };
});

return $conn;