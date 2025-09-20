<?php
// Display errors for debugging (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'plugins/PHPMailer/src/Exception.php';
require 'plugins/PHPMailer/src/PHPMailer.php';
require 'plugins/PHPMailer/src/SMTP.php';

class Mail {
    private PHPMailer $mailer;

    /**
     * @throws Exception
     */
    public function __construct() {
        //Load Composer's autoloader (created by composer, not included with PHPMailer)
        require 'plugins/PHPMailer/vendor/autoload.php';

        // Load configuration
        $config = include 'config/mail_config.php';
        $clientConfig = include 'config/mail_client_ics.php';

        //Create an instance; passing `true` enables exceptions
        $this->mailer = new PHPMailer(true);

        //Server settings
        # $this->mailer->SMTPDebug = SMTP::DEBUG_CONNECTION;
        # $this->mailer->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mailer->isSMTP();                                            //Send using SMTP
        $this->mailer->Host       = $config['host'];                     //Set the SMTP server to send through
        $this->mailer->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mailer->Username   = $config['username'];                     //SMTP username
        $this->mailer->Password   = $config['password'];                               //SMTP password
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mailer->Port       = $config['port'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $this->mailer->SMTPOptions = $config['options'];

        //Recipients
        $this->mailer->setFrom($clientConfig['from_email'], $clientConfig['from_name']);
    }

    public function sendMail(): void
    {
        $config = include 'config/mail_config.php';
        $clientConfig = include 'config/mail_client_ics.php';

        try {
            //Recipients
            $this->mailer->addAddress($config['to_mail'], $config['to_name']);     //Add a recipient
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $clientConfig['subject'];
            $this->mailer->Body    = $clientConfig['body'];
            $this->mailer->AltBody = $clientConfig['alt_body'];

            $this->mailer->send();
            echo "Message has been sent\n";
    } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }
}
