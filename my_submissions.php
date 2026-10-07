<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("SELECT projects.*, categories.category_name FROM projects INNER JOIN categories ON projects.category_id = categories.id WHERE projects.user_id = ? ORDER BY projects.created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

include "header.php";
?>

<div class="table-container">
    <h2>My Portfolio Submissions</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Project Title</th>
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