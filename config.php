<?php

// Site timezone
const SITE_TIMEZONE = 'Asia/Kolkata';

// Site information
const SITE_NAME = 'IAP PHP';
const SITE_URL = 'http://localhost/iap-php/';
const SITE_EMAIL = 'info@iap.com';

// Site language
const SITE_LANG = 'en';

// Database configuration
const DB_TYPE = 'mysql';
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'iap_php';

// Mail configuration
$config = include 'config/mail_config.php';
$clientConfig = include 'config/mail_client_ics.php';

return [
    'host'       => 'smtp.gmail.com',
    'username'   => $config['username'],
    'password'   => $config['password'],
    'port'       => 465,             // or 587 if you use STARTTLS
    'encryption' => PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS,
    'options'    => [  // Disbaled SSL verification (use with caution in production)
      $config['options']
    ],
    'to_mail'     => $clientConfig['to_mail'],
    'to_name'     => $clientConfig['to_name'],

    'from_email' => $clientConfig['from_email'],
    'from_name'  => $clientConfig['from_name'],

    'subject'    => $clientConfig['subject'],
    'body'      => $clientConfig['body'],
    'alt_body'  => $clientConfig['alt_body'],
];
/* MAIL CONFIGURATION DONE */