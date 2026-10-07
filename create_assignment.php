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
    $category_name = $_POST["category_name"];
    $description = $_POST["description"];

    if (empty($category_name)) {
        $error = "Category name is required.";
    } elseif (empty($description)) {
        $error = "Description is required.";
    } else {
        $stmt = $conn->prepare("INSERT INTO categories (category_name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $category_name, $description);

        if ($stmt->execute()) {
            $success = "Category created successfully.";
        } else {
            $error = "Failed to create category.";
        }
    }
}

include "header.php";
?>

<div class="container">
    <h2>Create Category</h2>

    <?php
    if ($error != "") echo "<p class='error'>$error</p>";
    if ($success != "") echo "<p class='success'>$success</p>";
    ?>

    <form method="post" onsubmit="return validateCategory()">
        <label>Category Name</label>
        <input type="text" id="category_name" name="category_name">

        <label>Description</label>
        <textarea id="category_description" name="description"></textarea>

        <button type="submit" name="create">Add Category</button>
    </form>
</div>

<script src="script.js"></script>

<?php include "footer.php"; ?>