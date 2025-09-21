<?php

require_once  'ClassAutoLoad.php';

#[AllowDynamicProperties] class Register {
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
            $password = trim($_POST['password'] ?? '');

            if (empty($name) || empty($email) || empty($password)) {
                $this->message = "❌ Name, email and password are required.";
                return;
            }

            $this->message = $this->mailer->registerUser($name, $email, $password);
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
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        </head>
        <body class="bg-light">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="mb-4 text-center">Register</h2>

                            <?php if (!empty($this->message)): ?>
                                <div class="alert alert-info">
                                    <?php echo htmlspecialchars($this->message); ?>
                                </div>
                            <?php endif; ?>

                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="nameInput" class="form-label">Name</label>
                                    <input
                                            type="text"
                                            name="name"
                                            class="form-control"
                                            id="nameInput"
                                            required
                                    >
                                </div>
                                <div class="mb-3">
                                    <label for="emailInput" class="form-label">Email address</label>
                                    <input
                                            type="email"
                                            name="email"
                                            class="form-control"
                                            id="emailInput"
                                            aria-describedby="emailHelp"
                                            required
                                    >
                                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="passwordInput" class="form-label">Password</label>
                                    <input
                                            type="password"
                                            name="password"
                                            class="form-control"
                                            id="passwordInput"
                                            placeholder="Enter your password"
                                            required
                                    >
                                </div>
                                <div class="mb-3 form-check">
                                    <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="showPasswordCheck"
                                            onclick="togglePassword()"
                                    >
                                    <label class="form-check-label" for="showPasswordCheck">
                                        Show Password
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function togglePassword() {
                const passwordField = document.getElementById('passwordInput');
                passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
            }
        </script>
        </body>
        </html>
        <?php
    }
}