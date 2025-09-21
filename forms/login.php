<?php

require_once  'ClassAutoLoad.php';

#[AllowDynamicProperties] class Login {
    private Mail $mailer;
    private mysqli $conn;
    public string $message = '';

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
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if (empty($email) || empty($password)) {
                $this->message = "❌ Email and password are required.";
                return;
            }

            $this->message = $this->mailer->loginUser($email, $password);
        }
    }

    /**
     * Display the login form
     */
    public function renderForm(): void
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>User Login</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        </head>
        <body class="bg-light">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="mb-4 text-center">Login</h2>

                            <?php if (!empty($this->message)): ?>
                                <div class="alert alert-info">
                                    <?php echo htmlspecialchars($this->message); ?>
                                </div>
                            <?php endif; ?>
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <p>Don't have an account? <a href="register">Sign Up</a></p>
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </body>
        </html>
        <?php
    }
}
