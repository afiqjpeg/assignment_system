<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}

$sql = "SELECT projects.id, users.full_name, users.email, categories.category_name, projects.title, projects.description, projects.tech_stack, projects.file_path, projects.created_at FROM projects INNER JOIN users ON projects.user_id = users.id INNER JOIN categories ON projects.category_id = categories.id ORDER BY projects.created_at DESC";

$result = $conn->query($sql);

include "header.php";
?>

<div class="table-container">
    <h2>All Student Submissions</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Student</th>
            <th>Email</th>
            <th>Project</th>
            <th>Category</th>
            <th>Tech Stack</th>
            <th>File</th>
            <th>Date</th>
        </tr>

        <?php
        $no = 1;

        while ($row = $result->fetch_assoc()) {
        ?>

        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row["full_name"]; ?></td>
            <td><?php echo $row["email"]; ?></td>
            <td><?php echo $row["title"]; ?></td>
            <td><?php echo $row["category_name"]; ?></td>
            <td><?php echo $row["tech_stack"]; ?></td>
            <td>
                <?php if (!empty($row["file_path"])) { ?>
                    <a href="<?php echo $row["file_path"]; ?>" download>Download</a>
                <?php } ?>
            </td>
            <td><?php echo $row["created_at"]; ?></td>
        </tr>

        <?php } ?>
    </table>
</div>

<?php include "footer.php"; ?>