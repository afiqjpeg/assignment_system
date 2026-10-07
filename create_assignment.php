<?php

session_start();

include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {

    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

if (isset($_POST["create"])) {

    $title = $_POST["title"];
    $description = $_POST["description"];

    if (empty($title)) {

        $error = "Assignment title is required.";

    } elseif (empty($description)) {

        $error = "Assignment description is required.";

    } else {

        $stmt = $conn->prepare("INSERT INTO assignments (title, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $description);

        if ($stmt->execute()) {

            $success = "Assignment created successfully.";

        } else {

            $error = "Failed to create assignment.";
        }
    }
}

include "header.php";

?>

<div class="container">

    <h2>Create Assignment</h2>

    <?php

    if ($error != "") {
        echo "<p class='error'>$error</p>";
    }

    if ($success != "") {
        echo "<p class='success'>$success</p>";
    }

    ?>

    <form method="post" onsubmit="return validateAssignment()">

        <label>Assignment Title</label>

        <input type="text" id="assignment_title" name="title">

        <label>Description</label>

        <textarea id="assignment_description" name="description"></textarea>

        <button type="submit" name="create">
            Create Assignment
        </button>

    </form>

</div>

<script src="script.js"></script>

<?php include "footer.php"; ?>