<?php

require 'config.php';

$directory = array('Global', 'layouts', 'forms');

spl_autoload_register(function ($className) use ($directory) {
    foreach ($directory as $dir) {
        $file = $dir . '/' . $className . '.php';
        if (file_exists($file)) {
            require $file;
        }
    };
});