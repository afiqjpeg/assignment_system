<?php

session_start();

include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "student") {

    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare("
    SELECT submissions.*, assignments.title
    FROM submissions
    INNER JOIN assignments
    ON submissions.assignment_id = assignments.assignment_id
    WHERE submissions.user_id = ?
    ORDER BY submissions.submitted_at DESC
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

include "header.php";

?>

<div class="table-container">

    <h2>My Submissions</h2>

    <table>

        <tr>

            <th>No</th>
            <th>Assignment</th>
            <th>File</th>
            <th>Date Submitted</th>

        </tr>

        <?php

        $no = 1;

        while ($row = $result->fetch_assoc()) {

        ?>

        <tr>

            <td><?php echo $no++; ?></td>

            <td>
                <?php echo $row["title"]; ?>
            </td>

            <td>

                <a href="<?php echo $row["file_path"]; ?>" download>

                    <?php echo $row["file_name"]; ?>

                </a>

            </td>

            <td>
                <?php echo $row["submitted_at"]; ?>
            </td>

        </tr>

        <?php } ?>

    </table>

</div>

<?php include "footer.php"; ?>