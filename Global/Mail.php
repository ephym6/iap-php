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

// Load DB connection (returns $conn)


class Mail {
    private PHPMailer $mailer;
    private mysqli $conn;

    /**
     * @throws Exception
     */
    public function __construct() {
        //Load Composer's autoloader (created by composer, not included with PHPMailer)
        if (file_exists('vendor/autoload.php')) {
            require 'plugins/PHPMailer/vendor/autoload.php';
        } else {
            echo "Composer autoload not found. Please run 'composer update in `/plugins/PHPMailer`'.\n";
            exit(1);
        }

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

    /**
     * Validate email, insert user and send a welcome email
     */
    public function registerUser(string $name, string $email): void
    {
        $conn = require_once 'config/db_conn.php';
        $this->conn = $conn;

        // 1️⃣ Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "❌ Invalid email address.";
            return;
        }

        // 2️⃣ Check if user exists
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "⚠️ User already registered.";
            return;
        }
        $stmt->close();

        // 3️⃣ Insert into DB
        $stmt = $this->conn->prepare("INSERT INTO users (name, email, created_at) VALUES (?, ?, NOW())");
        $stmt->bind_param('ss', $name, $email);

        if (!$stmt->execute()) {
            echo "❌ Failed to register user: " . $stmt->error;
            return;
        }
        $stmt->close();

        // 4️⃣ Send customized welcome email
        try {
            $this->mailer->addAddress($email, $name);
            $this->mailer->Subject = "Welcome to Our App, {$name}!";
            $this->mailer->Body    = "
                <h2>Hello {$name},</h2>
                <p>You requested an account on ICS 2.2</p>
                <p>In order to use this account you need to <a href=''>Click Here</a> to complete the registration process.</p>
                <br>
                <small>Regards,</small>
                <br>
                <small>Systems Admin</small>
                <br>
                <small>ICS 2.2</small>
            ";
            $this->mailer->AltBody = "Hello {$name},\n\nWelcome to our application!\n\n- The Team";

            $this->mailer->send();
            echo "✅ Registration successful. Email sent to {$email}.";
        } catch (Exception $e) {
            echo "✅ User saved, but email could not be sent. Error: {$this->mailer->ErrorInfo}";
        }
    }


    /*
    public function sendMail(): void
    {
        $config = include 'config/mail_config.php';
        $clientConfig = include 'config/mail_client_ics.php';

        try {
            //Recipients
            $this->mailer->addAddress($clientConfig['to_mail'], $clientConfig['to_name']);     //Add a recipient
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
    */
}
