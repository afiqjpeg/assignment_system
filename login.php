<?php

session_start();
require_once "db.php";

if (isset($_SESSION["user_id"])) {

    if ($_SESSION["role"] === "admin") {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: student_dashboard.php");
    }

    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {

        $error = "Please enter email and password.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        $stmt = $conn->prepare(
            "SELECT * FROM users WHERE email = ?"
        );

        $stmt->execute([$email]);

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["full_name"] = $user["full_name"];
            $_SESSION["role"] = $user["role"];

            if ($user["role"] === "admin") {

                header("Location: admin_dashboard.php");

            } else {

                header("Location: student_dashboard.php");
            }

            exit();

        } else {

            $error = "Incorrect email or password.";
        }
    }
}

require_once "header.php";

?>

<div class="container">

    <div class="auth-box">

        <div class="custom-card">

            <div class="card-body">

                <div class="text-center mb-4">

                    <h3 class="fw-bold">
                        Welcome Back
                    </h3>

                    <p class="text-muted">
                        Login to continue to PortfolioHub.
                    </p>

                </div>


                <?php if ($error): ?>

                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>

                <?php endif; ?>


                <form method="POST"
                      onsubmit="return validateLogin()">

                    <div class="mb-3">

                        <label class="form-label">
                            Email Address
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">

                    </div>


                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password">

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary w-100">

                        Login

                    </button>

                </form>


                <p class="text-center mt-3 mb-0">

                    New student?

                    <a href="register.php">
                        Create an account
                    </a>

                </p>

            </div>

        </div>

    </div>

</div>

<?php require_once "footer.php"; ?>