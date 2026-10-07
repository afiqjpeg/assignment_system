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

    <p>
        Welcome,
        <?php echo $_SESSION["full_name"]; ?>
    </p>

    <h3>Assignments</h3>

    <input type="text"
           id="search"
           placeholder="Search assignment..."
           onkeyup="searchAssignment()">

    <div id="assignmentResult"></div>

</div>

<script src="script.js"></script>

<script>

window.onload = function() {
    searchAssignment();
};

</script>

<?php include "footer.php"; ?>