<?php

session_start();

if (isset($_SESSION["user_id"])) {

    if ($_SESSION["role"] === "admin") {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: student_dashboard.php");
    }

    exit();
}

require_once "header.php";

?>

<div class="container hero">

    <div class="row align-items-center">

        <div class="col-lg-7">

            <span class="badge text-bg-primary mb-3">
                Student Project Showcase
            </span>

            <h1>
                Build it. Submit it.
                <br>
                Showcase your work.
            </h1>

            <p class="hero-text mt-3">
                A centralized platform for students to submit
                and showcase their academic projects and Final
                Year Projects.
            </p>

            <div class="mt-4">

                <a href="register.php"
                   class="btn btn-primary btn-lg me-2">
                    Get Started
                </a>

                <a href="login.php"
                   class="btn btn-outline-primary btn-lg">
                    Login
                </a>

            </div>

        </div>

        <div class="col-lg-5 mt-5 mt-lg-0">

            <div class="custom-card">

                <div class="card-body">

                    <h4 class="fw-bold">
                        PortfolioHub
                    </h4>

                    <p class="text-muted">
                        Manage academic projects in one place.
                    </p>

                    <hr>

                    <p>✓ Secure student accounts</p>
                    <p>✓ Project file submission</p>
                    <p>✓ Project categories</p>
                    <p>✓ Live project search</p>

                </div>

            </div>

        </div>

    </div>

</div>

<?php require_once "footer.php"; ?>