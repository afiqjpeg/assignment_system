<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}

$studentResult = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'student'");
$studentData = $studentResult->fetch_assoc();
$totalStudents = $studentData["total"];

$categoryResult = $conn->query("SELECT COUNT(*) AS total FROM categories");
$categoryData = $categoryResult->fetch_assoc();
$totalCategories = $categoryData["total"];

$projectResult = $conn->query("SELECT COUNT(*) AS total FROM projects");
$projectData = $projectResult->fetch_assoc();
$totalProjects = $projectData["total"];

// Get current name from database, including for older login sessions.
$stmtName = $conn->prepare("SELECT full_name FROM users WHERE id = ?");
$stmtName->bind_param("i", $_SESSION["user_id"]);
$stmtName->execute();
$nameRow = $stmtName->get_result()->fetch_assoc();
$stmtName->close();
if (!$nameRow) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$_SESSION["full_name"] = $nameRow["full_name"];

include "header.php";
?>

<div class="dashboard">
    <h2>Admin Dashboard</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION["full_name"], ENT_QUOTES, "UTF-8"); ?></p>

    <div class="card-container">
        <div class="card">
            <h3>Students</h3>
            <p><?php echo $totalStudents; ?></p>
        </div>

        <div class="card">
            <h3>Categories</h3>
            <p><?php echo $totalCategories; ?></p>
        </div>

        <div class="card">
            <h3>Projects</h3>
            <p><?php echo $totalProjects; ?></p>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>