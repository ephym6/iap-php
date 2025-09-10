<?php
// include the class file
include 'classes.php';
// or use require 'classes.php';
require 'config.php';

// create instance of the class
$sample = new Sample();
// call the greet method
echo $sample->greet() . "\n";
echo $sample->week_day() . "\n";

print '<br>';
print 'Copyright &copy; 2025 - ' . SITE_NAME . ' - All rights reserved.';
print '<br>';
