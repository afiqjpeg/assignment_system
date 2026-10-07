<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: login.php");
    exit();
}

$error = "";
$success = "";
$user_id = $_SESSION["user_id"];

if (isset($_POST["submit"])) {
    $title = $_POST["title"];
    $category_id = $_POST["category_id"];
    $tech_stack = $_POST["tech_stack"];
    $description = $_POST["description"];

    if (empty($title)) {
        $error = "Project title is required.";
    } elseif (empty($category_id)) {
        $error = "Please select category.";
    } elseif (empty($tech_stack)) {
        $error = "Tech stack is required.";
    } elseif (empty($description)) {
        $error = "Project description is required.";
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
                $stmt = $conn->prepare("INSERT INTO projects (user_id, category_id, title, description, tech_stack, file_path) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("iissss", $user_id, $category_id, $title, $description, $tech_stack, $filePath);

                if ($stmt->execute()) {
                    $success = "Project submitted successfully.";
                } else {
                    $error = "Failed to save project.";
                }
            } else {
                $error = "Failed to upload file.";
            }
        }
    }
}

$categoryResult = $conn->query("SELECT * FROM categories ORDER BY category_name ASC");

include "header.php";
?>

<div class="container">
    <h2>Submit Portfolio Project</h2>

    <?php
    if ($error != "") echo "<p class='error'>$error</p>";
    if ($success != "") echo "<p class='success'>$success</p>";
    ?>

    <form method="post" enctype="multipart/form-data" onsubmit="return validateSubmission()">
        <label>Project Title</label>
        <input type="text" id="project_title" name="title">

        <label>Category</label>
        <select id="category_id" name="category_id">
            <option value="">Select Category</option>

            <?php while ($row = $categoryResult->fetch_assoc()) { ?>
                <option value="<?php echo $row["id"]; ?>"><?php echo $row["category_name"]; ?></option>
            <?php } ?>
        </select>

        <label>Tech Stack</label>
        <input type="text" id="tech_stack" name="tech_stack" placeholder="Example: PHP, MySQL, Bootstrap">

        <label>Project Description</label>
        <textarea id="project_description" name="description"></textarea>

        <label>Upload Documentation</label>
        <input type="file" id="project_file" name="file">

        <small>Allowed: PDF, DOCX, TXT. Maximum 5MB.</small>

        <button type="submit" name="submit">Submit Project</button>
    </form>
</div>

<script src="script.js"></script>

<?php include "footer.php"; ?>