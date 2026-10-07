<?php

session_start();

include "db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {

    header("Location: login.php");
    exit();
}

$sql = "
SELECT
    submissions.submission_id,
    users.full_name,
    users.email,
    assignments.title,
    submissions.file_name,
    submissions.file_path,
    submissions.submitted_at
FROM submissions
INNER JOIN users
ON submissions.user_id = users.user_id
INNER JOIN assignments
ON submissions.assignment_id = assignments.assignment_id
ORDER BY submissions.submitted_at DESC
";

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
                <?php echo $row["full_name"]; ?>
            </td>

            <td>
                <?php echo $row["email"]; ?>
            </td>

            <td>
                <?php echo $row["title"]; ?>
            </td>

            <td>

                <a href="<?php echo $row["file_path"]; ?>" download>
                    Download
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