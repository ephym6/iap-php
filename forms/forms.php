<?php

class Forms {
    public function signUp() {
?>
        <form action="submit.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <?php $this->submitButton('Sign Up'); ?> <a href="/login.php">Already have an account? Log in</a>
        </form>
<?php
    }

    public function signIn() {
?>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>
            <?php $this->submitButton('Log In'); ?> <a href="/index.php">Don't have an account? Sign up</a>
        </form>
<?php
    }

    public function submitButton() {
        echo '<button type="submit">Submit</button>';
    }
}
