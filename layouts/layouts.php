<?php

class Layouts {
    public function header() {
        echo "<header><h1>Welcome to " . SITE_NAME . "</h1></header>";
    }

    public function footer() {
        echo "<footer>Copyright &copy; " . date("Y") . " - " . SITE_NAME . " - All rights reserved.</footer>";
    }
}
