<?php

include "db.php";

$search = $_GET["search"] ?? "";

$search = "%" . $search . "%";

$stmt = $conn->prepare("SELECT * FROM assignments WHERE title LIKE ? OR description LIKE ? ORDER BY created_at DESC");
$stmt->bind_param("ss", $search, $search);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        echo "<div class='assignment-card'>";

        echo "<h3>" . htmlspecialchars($row["title"]) . "</h3>";

        echo "<p>" . htmlspecialchars($row["description"]) . "</p>";

        echo "<small>";
        echo "Created: " . $row["created_at"];
        echo "</small>";

        echo "</div>";
    }

} else {

    echo "<p>No assignment found.</p>";
}

?>