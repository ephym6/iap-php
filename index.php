<?php

require 'ClassAutoLoad.php';

// Class instances
$sample = new Sample();
$layout = new Layouts();
$forms = new Forms();
$mail = new Mail();

$layout->header();

$forms->signUp();

$mail->sendMail();

$layout->footer();
