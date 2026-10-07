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
    "SELECT COUNT(*) FROM projects WHERE user_id = ?"
);

$stmt->execute([$_SESSION["user_id"]]);

$myProjects = $stmt->fetchColumn();


$stmt = $conn->prepare(
    "SELECT COUNT(*) FROM categories"
);

$stmt->execute();

$totalCategories = $stmt->fetchColumn();

require_once "header.php";

?>

<div class="container">

    <div class="page-heading">

        <h2>
            Welcome, <?= htmlspecialchars($_SESSION["full_name"]) ?>
        </h2>

        <p class="text-muted">
            Manage and showcase your academic projects.
        </p>

    </div>


    <div class="row g-4 mb-4">

        <div class="col-md-6">

            <div class="stat-card">

                <p class="text-muted mb-1">
                    My Submissions
                </p>

                <div class="stat-number">
                    <?= $myProjects ?>
                </div>

            </div>

        </div>


        <div class="col-md-6">

            <div class="stat-card">

                <p class="text-muted mb-1">
                    Available Categories
                </p>

                <div class="stat-number">
                    <?= $totalCategories ?>
                </div>

            </div>

        </div>

    </div>


    <div class="custom-card">

        <div class="card-body">

            <div class="d-flex justify-content-between
                        align-items-center mb-3">

                <div>

                    <h4 class="fw-bold mb-1">
                        Explore Projects
                    </h4>

                    <p class="text-muted mb-0">
                        Search projects without refreshing the page.
                    </p>

                </div>

                <a href="submit_assignment.php"
                   class="btn btn-primary">

                    Submit Project

                </a>

            </div>


            <input
                type="text"
                id="search"
                class="form-control mb-4"
                placeholder="Search by project title or technology...">


            <div id="projectResults">

                <div class="text-muted">
                    Loading projects...
                </div>

            </div>

        </div>

    </div>

</div>


<script>

const searchInput = document.getElementById("search");
const projectResults = document.getElementById("projectResults");

function loadProjects(keyword = "") {

    fetch(
        "search_assignment.php?search=" +
        encodeURIComponent(keyword)
    )
    .then(response => response.text())
    .then(data => {
        projectResults.innerHTML = data;
    })
    .catch(() => {
        projectResults.innerHTML =
            '<div class="alert alert-danger">Unable to load projects.</div>';
    });
}

loadProjects();

searchInput.addEventListener("input", function () {
    loadProjects(this.value);
});

</script>

<?php require_once "footer.php"; ?>