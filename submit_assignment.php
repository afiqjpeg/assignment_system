<?php

session_start();

include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {

    header("Location: login.php");
    exit();
}

$error = "";
$success = "";

if (isset($_POST["submit"])) {

    $assignment_id = $_POST["assignment_id"];
    $user_id = $_SESSION["user_id"];

    if (empty($assignment_id)) {

        $error = "Please select an assignment.";

    } elseif (!isset($_FILES["file"]) || $_FILES["file"]["error"] != 0) {

        $error = "Please select a file.";

    } else {

        $fileName = $_FILES["file"]["name"];
        $fileTmp = $_FILES["file"]["tmp_name"];
        $fileSize = $_FILES["file"]["size"];

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedFile = array("pdf", "docx", "txt");

        if (!in_array($fileExtension, $allowedFile)) {

            $error = "Only PDF, DOCX and TXT files are allowed.";

        } elseif ($fileSize > 5000000) {

            $error = "File size must be less than 5MB.";

        } else {

            $newFileName = time() . "_" . $fileName;

            $filePath = "uploads/" . $newFileName;

            if (move_uploaded_file($fileTmp, $filePath)) {

                $stmt = $conn->prepare("INSERT INTO submissions (user_id, assignment_id, file_name, file_path) VALUES (?, ?, ?, ?)");

                $stmt->bind_param("iiss", $user_id, $assignment_id, $fileName, $filePath);

                if ($stmt->execute()) {

                    $success = "Assignment submitted successfully.";

                } else {

                    $error = "Failed to save submission.";
                }

            } else {

                $error = "Failed to upload file.";
            }
        }
    }
}

$assignmentResult = $conn->query("SELECT * FROM assignments ORDER BY created_at DESC");

include "header.php";

?>

<div class="container">

    <h2>Submit Assignment</h2>

    <?php

    if ($error != "") {
        echo "<p class='error'>$error</p>";
    }

    if ($success != "") {
        echo "<p class='success'>$success</p>";
    }

    ?>

    <form method="post" enctype="multipart/form-data" onsubmit="return validateSubmission()">

        <label>Select Assignment</label>

        <select name="assignment_id" id="assignment_id">

            <option value="">Select Assignment</option>

            <?php while ($row = $assignmentResult->fetch_assoc()) { ?>

                <option value="<?php echo $row["assignment_id"]; ?>">

                    <?php echo $row["title"]; ?>

                </option>

            <?php } ?>

        </select>

        <label>Upload File</label>

        <input type="file" id="assignment_file" name="file">

        <small>Allowed: PDF, DOCX, TXT. Maximum 5MB.</small>

        <button type="submit" name="submit">
            Submit Assignment
        </button>

    </form>

</div>

<script src="script.js"></script>

<?php include "footer.php"; ?>