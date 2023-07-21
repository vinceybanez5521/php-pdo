<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP PDO</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/php-pdo/css/style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md bg-primary navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/php-pdo/">PHP PDO</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['is_authenticated'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/php-pdo/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/php-pdo/employees/">Employees</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/php-pdo/positions">Positions</a>
                        </li>
                    <?php endif; ?>

                    <?php if (!isset($_SESSION['is_authenticated'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/php-pdo/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/php-pdo/register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <section class="content">
        <div class="container pt-4 pb-5">