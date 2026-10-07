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
    "SELECT COUNT(*) FROM users WHERE role = 'student'"
);

$stmt->execute();

$totalStudents = $stmt->fetchColumn();


$stmt = $conn->prepare(
    "SELECT COUNT(*) FROM projects"
);

$stmt->execute();

$totalProjects = $stmt->fetchColumn();


$stmt = $conn->prepare(
    "SELECT COUNT(*) FROM categories"
);

$stmt->execute();

$totalCategories = $stmt->fetchColumn();


$stmt = $conn->prepare(
    "SELECT
        projects.title,
        projects.created_at,
        users.full_name,
        categories.category_name
    FROM projects
    JOIN users
        ON projects.user_id = users.id
    JOIN categories
        ON projects.category_id = categories.id
    ORDER BY projects.created_at DESC
    LIMIT 5"
);

$stmt->execute();

$recentProjects = $stmt->fetchAll();

require_once "header.php";

?>

<div class="container">

    <div class="page-heading">

        <h2>Admin Dashboard</h2>

        <p class="text-muted">
            Overview of PortfolioHub.
        </p>

    </div>


    <div class="row g-4 mb-4">

        <div class="col-md-4">

            <div class="stat-card">

                <p class="text-muted">
                    Students
                </p>

                <div class="stat-number">
                    <?= $totalStudents ?>
                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="stat-card">

                <p class="text-muted">
                    Projects
                </p>

                <div class="stat-number">
                    <?= $totalProjects ?>
                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="stat-card">

                <p class="text-muted">
                    Categories
                </p>

                <div class="stat-number">
                    <?= $totalCategories ?>
                </div>

            </div>

        </div>

    </div>


    <div class="table-container">

        <div class="d-flex justify-content-between
                    align-items-center mb-3">

            <h4 class="fw-bold mb-0">
                Recent Submissions
            </h4>

            <a href="view_submissions.php"
               class="btn btn-outline-primary btn-sm">

                View All

            </a>

        </div>


        <?php if (!$recentProjects): ?>

            <p class="text-muted">
                No project submissions yet.
            </p>

        <?php else: ?>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>
                        <th>Student</th>
                        <th>Project</th>
                        <th>Category</th>
                        <th>Date</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach ($recentProjects as $project): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars(
                                $project["full_name"]
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $project["title"]
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $project["category_name"]
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

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <?php endif; ?>

    </div>

</div>

<?php require_once "footer.php"; ?>