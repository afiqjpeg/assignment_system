<?php

session_start();
require_once "db.php";

if (
    !isset($_SESSION["user_id"]) ||
    $_SESSION["role"] !== "admin"
) {
    header("Location: login.php");
    exit();
}


$stmt = $conn->prepare(
    "SELECT
        projects.id,
        projects.title,
        projects.description,
        projects.tech_stack,
        projects.file_path,
        projects.created_at,
        users.full_name,
        users.email,
        categories.category_name
    FROM projects
    JOIN users
        ON projects.user_id = users.id
    JOIN categories
        ON projects.category_id = categories.id
    ORDER BY projects.created_at DESC"
);

$stmt->execute();

$submissions = $stmt->fetchAll();

require_once "header.php";

?>

<div class="container">

    <div class="page-heading">

        <h2>Student Submissions</h2>

        <p class="text-muted">
            View and download submitted student projects.
        </p>

    </div>


    <div class="table-container">

        <?php if (!$submissions): ?>

            <div class="text-center py-5">

                <h5>No submissions found</h5>

                <p class="text-muted mb-0">
                    Student submissions will appear here.
                </p>

            </div>

        <?php else: ?>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Student</th>
                            <th>Project</th>
                            <th>Category</th>
                            <th>Technology</th>
                            <th>Date</th>
                            <th>File</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($submissions as $submission): ?>

                        <tr>

                            <td>

                                <strong>
                                    <?= htmlspecialchars(
                                        $submission["full_name"]
                                    ) ?>
                                </strong>

                                <br>

                                <small class="text-muted">
                                    <?= htmlspecialchars(
                                        $submission["email"]
                                    ) ?>
                                </small>

                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $submission["title"]
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $submission["category_name"]
                                ) ?>
                            </td>


                            <td>
                                <?= htmlspecialchars(
                                    $submission["tech_stack"]
                                ) ?>
                            </td>


                            <td>
                                <?= date(
                                    "d M Y",
                                    strtotime(
                                        $submission["created_at"]
                                    )
                                ) ?>
                            </td>


                            <td>

                                <a
                                    href="<?= htmlspecialchars(
                                        $submission["file_path"]
                                    ) ?>"
                                    class="btn btn-sm btn-primary"
                                    download>

                                    Download

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