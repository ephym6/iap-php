<?php

$conn = require_once 'ClassAutoLoad.php';

// Class instances
$sample = new Sample();
$layout = new Layouts();
$forms = new Forms();
$mail = new Mail($conn);
$register = new Register($conn);

$layout->header();

$register->handleForm();
$register->renderForm();

// $mail->sendMail();

$layout->footer();
