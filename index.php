<?php

require 'routes/Route.php';
require_once 'ClassAutoLoad.php';
$conn = require __DIR__ . '/config/db_conn.php';

// Making sure I actually have a mysqli connection
if (!$conn instanceof mysqli) {
    http_response_code(500);
    echo "Database initialization failed.";
    exit;
}

// Class instances
$sample = new Sample();
$layout = new Layouts();
$forms = new Forms();
$mail = new Mail($conn);
$register = new Register($conn);
$login = new Login($conn);
$router = new Router();


// Define routes
$router->add('home', function () {
    echo "<h1>Welcome Home!</h1>";
});

$router->add('register', function() use ($register, $layout) {
    $layout->header();
    $register->handleForm();
    $register->renderForm();
    $layout->footer();
});

$router->add('login', function() use ($login, $layout) {
    $layout->header();
    $login->renderForm();
    $layout->footer();
});

$router->add('users-list', function () use ($conn) {
    include __DIR__ . '/tables/list_users.php';
});

// Dispatch the current request
$router->dispatch($_SERVER['REQUEST_URI']);
