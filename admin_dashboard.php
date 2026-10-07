<?php

session_start();

include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {

    header("Location: login.php");
    exit();
}

include "header.php";

$studentResult = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'student'");
$studentData = $studentResult->fetch_assoc();
$totalStudents = $studentData["total"];

$assignmentResult = $conn->query("SELECT COUNT(*) AS total FROM assignments");
$assignmentData = $assignmentResult->fetch_assoc();
$totalAssignments = $assignmentData["total"];

$submissionResult = $conn->query("SELECT COUNT(*) AS total FROM submissions");
$submissionData = $submissionResult->fetch_assoc();
$totalSubmissions = $submissionData["total"];

?>

<div class="dashboard">

    <h2>Admin Dashboard</h2>

    <p>
        Welcome,
        <?php echo $_SESSION["full_name"]; ?>
    </p>

    <div class="card-container">

        <div class="card">
            <h3>Students</h3>
            <p><?php echo $totalStudents; ?></p>
        </div>

        <div class="card">
            <h3>Assignments</h3>
            <p><?php echo $totalAssignments; ?></p>
        </div>

        <div class="card">
            <h3>Submissions</h3>
            <p><?php echo $totalSubmissions; ?></p>
        </div>

    </div>

</div>

<?php include "footer.php"; ?>