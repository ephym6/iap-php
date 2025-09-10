<?php
require 'ClassAutoLoad.php';

$layout = new Layouts();
$forms = new Forms();

$layout->header();
$forms->signIn();
$layout->footer();
