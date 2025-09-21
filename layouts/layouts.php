<?php

class Layouts {
    public function header(): void
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?php echo SITE_NAME; ?></title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        </head>
        <body class="bg-light">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#"><?php echo SITE_NAME; ?></a>
            </div>
        </nav>
        <main class="container my-5">
        <?php
    }

    public function footer(): void
    {
        ?>
        </main>
        <footer class="bg-dark text-white text-center py-3 mt-5">
            <div class="container">
                <small>
                    &copy; <?php echo date("Y"); ?> <?php echo SITE_NAME; ?> — All rights reserved.
                </small>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        </body>
        </html>
        <?php
    }
}
