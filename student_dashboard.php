<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: login.php");
    exit();
}

include "header.php";
?>

<div class="dashboard">
    <h2>Student Dashboard</h2>
    <p>Welcome, <?php echo $_SESSION["full_name"]; ?></p>

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