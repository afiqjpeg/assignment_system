<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="header">
    <h2>Assignment System</h2>

    <nav class="header-menu">
        <?php if ($_SESSION["role"] == "admin") { ?>

            <a href="admin_dashboard.php">Dashboard</a>
            <a href="create_assignment.php">Create Assignment</a>
            <a href="view_submissions.php">View Submissions</a>
            <a href="logout.php">Logout</a>

        <?php } else { ?>

            <a href="student_dashboard.php">Dashboard</a>
            <a href="submit_assignment.php">Submit Project</a>
            <a href="my_submissions.php">My Portfolio</a>
            <a href="logout.php">Logout</a>

        <?php } ?>
    </nav>
</header>

<main>