<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentPage = basename($_SERVER["PHP_SELF"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>PortfolioHub</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark main-navbar">
    <div class="container">

        <a class="navbar-brand fw-bold" href="index.php">
            PortfolioHub
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainMenu">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="mainMenu">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <?php if (!isset($_SESSION["user_id"])): ?>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="login.php">
                            Login
                        </a>
                    </li>

                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-light btn-sm px-3"
                           href="register.php">
                            Register
                        </a>
                    </li>


                <?php elseif ($_SESSION["role"] === "student"): ?>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="student_dashboard.php">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="submit_assignment.php">
                            Submit Project
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="my_submissions.php">
                            My Submissions
                        </a>
                    </li>

                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-light btn-sm"
                           href="logout.php">
                            Logout
                        </a>
                    </li>


                <?php elseif ($_SESSION["role"] === "admin"): ?>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="admin_dashboard.php">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="create_assignment.php">
                            Categories
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="view_submissions.php">
                            Submissions
                        </a>
                    </li>

                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-light btn-sm"
                           href="logout.php">
                            Logout
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>