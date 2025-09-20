<?php

$config = include 'config/mail_config.php';

$toName = $config['to_name'];

return [
    'from_email' => 'no-reply@ics2.2.com',
    'from_name'  => 'ICS 2.2 App',

    'to_mail'     => 'ephymbuu06@gmail.com',
    'to_name'     => 'Mbuu',

    'subject'    => 'Welcome to ICS 2.2 App',
    'body'      => "Hello <b>$toName</b>,<br>Welcome to ICS 2.2 App.<br><br>Thank you for signing up! We're excited to have you on board.<br><br>Best regards,<br>ICS 2.2 App Team",
    'alt_body'  => "",
];