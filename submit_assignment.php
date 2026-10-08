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
    $title = trim($_POST["title"] ?? "");
    $category_id = (int)($_POST["category_id"] ?? 0);
    $tech_stack = trim($_POST["tech_stack"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if ($title == "") {
        $error = "Project title is required.";
    } elseif ($category_id <= 0) {
        $error = "Please select category.";
    } elseif ($tech_stack == "") {
        $error = "Tech stack is required.";
    } elseif ($description == "") {
        $error = "Project description is required.";
    } elseif (!isset($_FILES["file"]) || $_FILES["file"]["error"] != UPLOAD_ERR_OK) {
        $error = "Please select a valid file (maximum 5MB).";
    } else {
        $fileName = $_FILES["file"]["name"];
        $fileTmp = $_FILES["file"]["tmp_name"];
        $fileSize = $_FILES["file"]["size"];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedFile = array("pdf", "docx", "txt");

        $categoryStmt = $conn->prepare("SELECT id FROM categories WHERE id = ?");
        $categoryStmt->bind_param("i", $category_id);
        $categoryStmt->execute();
        $validCategory = $categoryStmt->get_result()->num_rows > 0;
        $categoryStmt->close();

        if (!$validCategory) {
            $error = "Invalid category.";
        } elseif (!in_array($fileExtension, $allowedFile, true)) {
            $error = "Only PDF, DOCX and TXT files are allowed.";
        } elseif ($fileSize > 5000000) {
            $error = "File size must be less than 5MB.";
        } else {
            $mime = (new finfo(FILEINFO_MIME_TYPE))->file($fileTmp);
            $validMime = array(
                "pdf" => array("application/pdf"),
                "docx" => array("application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/zip"),
                "txt" => array("text/plain")
            );
            if (!in_array($mime, $validMime[$fileExtension], true)) {
                $error = "File content does not match the selected format.";
            } else {
                $uploadDir = __DIR__ . "/uploads/";
                if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                    $error = "Unable to create upload folder.";
                } else {
                    $newFileName = bin2hex(random_bytes(12)) . "." . $fileExtension;
                    $filePath = "uploads/" . $newFileName;
                    if (move_uploaded_file($fileTmp, $uploadDir . $newFileName)) {
                        $stmt = $conn->prepare("INSERT INTO projects (user_id, category_id, title, description, tech_stack, file_path) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("iissss", $user_id, $category_id, $title, $description, $tech_stack, $filePath);
                        if ($stmt->execute()) {
                            $success = "Project submitted successfully.";
                        } else {
                            unlink($uploadDir . $newFileName);
                            $error = "Failed to save project.";
                        }
                        $stmt->close();
                    } else {
                        $error = "Failed to upload file. Check uploads folder permission.";
                    }
                }
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
    if ($error != "") echo "<p class='error'>" . htmlspecialchars($error) . "</p>";
    if ($success != "") echo "<p class='success'>" . htmlspecialchars($success) . "</p>";
    ?>

    <form method="post" enctype="multipart/form-data" onsubmit="return validateSubmission()">
        <label>Project Title</label>
        <input type="text" id="project_title" name="title">

        <label>Category</label>
        <select id="category_id" name="category_id">
            <option value="">Select Category</option>

            <?php while ($row = $categoryResult->fetch_assoc()) { ?>
                <option value="<?php echo $row["id"]; ?>"><?php echo htmlspecialchars($row["category_name"], ENT_QUOTES, "UTF-8"); ?></option>
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