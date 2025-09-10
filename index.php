<?php

require 'ClassAutoLoad.php';

// Class instances
$sample = new Sample();
$layout = new Layouts();
$forms = new Forms();

$layout->header();

$forms->signUp();

$layout->footer();
