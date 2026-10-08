<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: login.php");
    exit();
}

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
    <h2>Student Dashboard</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION["full_name"], ENT_QUOTES, "UTF-8"); ?></p>

    <h3>Project Showcase Directory</h3>

    <input type="text" id="search" placeholder="Search project..." onkeyup="searchProject()">

    <div id="projectResult"></div>
</div>

<script src="script.js"></script>

<script>
window.onload = function() {
    searchProject();
};
</script>

<?php include "footer.php"; ?>