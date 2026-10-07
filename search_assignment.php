<?php

session_start();
require_once "db.php";

if (
    !isset($_SESSION["user_id"]) ||
    $_SESSION["role"] !== "student"
) {
    exit("Access denied.");
}

$search = trim($_GET["search"] ?? "");

$sql = "
    SELECT
        projects.title,
        projects.description,
        projects.tech_stack,
        categories.category_name,
        users.full_name
    FROM projects
    JOIN users
        ON projects.user_id = users.id
    JOIN categories
        ON projects.category_id = categories.id
    WHERE projects.title LIKE ?
       OR projects.tech_stack LIKE ?
    ORDER BY projects.created_at DESC
";

$stmt = $conn->prepare($sql);

$keyword = "%" . $search . "%";

$stmt->execute([
    $keyword,
    $keyword
]);

$projects = $stmt->fetchAll();


if (!$projects) {

    echo '
    <div class="text-center py-4 text-muted">
        No projects found.
    </div>
    ';

    exit();
}


foreach ($projects as $project) {
?>

<div class="project-card">

    <div class="d-flex justify-content-between
                align-items-start">

        <div>

            <span class="badge text-bg-light mb-2">
                <?= htmlspecialchars($project["category_name"]) ?>
            </span>

            <h5>
                <?= htmlspecialchars($project["title"]) ?>
            </h5>

        </div>

    </div>


    <p class="text-muted">
        <?= nl2br(htmlspecialchars($project["description"])) ?>
    </p>


    <div class="small">

        <strong>Technology:</strong>
        <?= htmlspecialchars($project["tech_stack"]) ?>

        <br>

        <strong>Student:</strong>
        <?= htmlspecialchars($project["full_name"]) ?>

    </div>

</div>

<?php
}
?>