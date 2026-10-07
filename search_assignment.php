<?php
include "db.php";

$search = $_GET["search"] ?? "";
$search = "%" . $search . "%";

$stmt = $conn->prepare("SELECT projects.*, users.full_name, categories.category_name FROM projects INNER JOIN users ON projects.user_id = users.id INNER JOIN categories ON projects.category_id = categories.id WHERE projects.title LIKE ? OR projects.description LIKE ? OR projects.tech_stack LIKE ? OR users.full_name LIKE ? ORDER BY projects.created_at DESC");
$stmt->bind_param("ssss", $search, $search, $search, $search);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='assignment-card'>";
        echo "<h3>" . htmlspecialchars($row["title"]) . "</h3>";
        echo "<p>" . htmlspecialchars($row["description"]) . "</p>";
        echo "<p><strong>Category:</strong> " . htmlspecialchars($row["category_name"]) . "</p>";
        echo "<p><strong>Tech Stack:</strong> " . htmlspecialchars($row["tech_stack"]) . "</p>";
        echo "<p><strong>Student:</strong> " . htmlspecialchars($row["full_name"]) . "</p>";

        if (!empty($row["file_path"])) {
            echo "<p><a href='" . $row["file_path"] . "' download>Download File</a></p>";
        }

        echo "</div>";
    }
} else {
    echo "<p>No project found.</p>";
}
?>