<?php

session_start();
require_once "db.php";

if (
    !isset($_SESSION["user_id"]) ||
    $_SESSION["role"] !== "student"
) {
    header("Location: login.php");
    exit();
}


$stmt = $conn->prepare(
    "SELECT
        projects.*,
        categories.category_name
    FROM projects
    JOIN categories
        ON projects.category_id = categories.id
    WHERE projects.user_id = ?
    ORDER BY projects.created_at DESC"
);

$stmt->execute([
    $_SESSION["user_id"]
]);

$projects = $stmt->fetchAll();

require_once "header.php";

?>

<div class="container">

    <div class="page-heading">

        <h2>My Submissions</h2>

        <p class="text-muted">
            View all projects you have submitted.
        </p>

    </div>


    <div class="table-container">

        <?php if (!$projects): ?>

            <div class="text-center py-5">

                <h5>No submissions yet</h5>

                <p class="text-muted">
                    Your submitted projects will appear here.
                </p>

                <a href="submit_assignment.php"
                   class="btn btn-primary">

                    Submit Project

                </a>

            </div>

        <?php else: ?>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Project</th>
                            <th>Category</th>
                            <th>Technology</th>
                            <th>Date</th>
                            <th>File</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($projects as $project): ?>

                        <tr>

                            <td>
                                <strong>
                                    <?= htmlspecialchars(
                                        $project["title"]
                                    ) ?>
                                </strong>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $project["category_name"]
                                ) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars(
                                    $project["tech_stack"]
                                ) ?>
                            </td>

                            <td>
                                <?= date(
                                    "d M Y",
                                    strtotime(
                                        $project["created_at"]
                                    )
                                ) ?>
                            </td>

                            <td>

                                <a
                                    href="<?= htmlspecialchars(
                                        $project["file_path"]
                                    ) ?>"
                                    class="btn btn-sm btn-outline-primary"
                                    target="_blank">

                                    View File

                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

</div>

<?php require_once "footer.php"; ?>