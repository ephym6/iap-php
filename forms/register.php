<?php

require_once  'ClassAutoLoad.php';

class Register {
    private Mail $mailer;
    private mysqli $conn;

    /**
     * @throws Exception
     */

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
        $this->mailer = new Mail($this->conn);
    }

    /**
     * Handle form submission
     */
    public function handleForm(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name  = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');

            if (empty($name) || empty($email)) {
                echo "❌ Name and email are required.";
                return;
            }

            $this->mailer->registerUser($name, $email);
        }
    }

    /**
     * Display the registration form
     */
    public function renderForm(): void
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>User Registration</title>
        </head>
        <body>
        <h2>Register</h2>
        <form method="post" action="">
            <label>Name:
                <input type="text" name="name" required>
            </label><br><br>
            <label>Email:
                <input type="email" name="email" required>
            </label><br><br>
            <button type="submit">Register</button>
        </form>
        </body>
        </html>
        <?php
    }
}