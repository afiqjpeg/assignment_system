<?php

session_start();

include "db.php";

$error = "";

// Check if already login
if (isset($_SESSION["user_id"])) {

    if ($_SESSION["role"] == "admin") {

        header("Location: admin_dashboard.php");

    } else {

        header("Location: student_dashboard.php");
    }

    exit();
}


// Login process
if (isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Server-side validation
    if (empty($email)) {

        $error = "Email is required.";

    } elseif (empty($password)) {

        $error = "Password is required.";

    } else {

        // Find user
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $user = $result->fetch_assoc();

            // Verify hashed password
            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["full_name"] = $user["full_name"];
                $_SESSION["role"] = $user["role"];

                // Redirect according to role
                if ($user["role"] == "admin") {

                    header("Location: admin_dashboard.php");

                } else {

                    header("Location: student_dashboard.php");
                }

                exit();

            } else {

                $error = "Incorrect password.";
            }

        } else {

            $error = "Email not found.";
        }
    }
}

include "header.php";

?>

<div class="container">

    <div class="auth-box">

        <div class="custom-card">

            <div class="card-body">

                <h2>Login</h2>

                <?php

                if ($error != "") {
                    echo "<p class='error'>$error</p>";
                }

                ?>

                <form method="post" onsubmit="return validateLogin()">

                    <label>Email Address</label>

                    <input type="email"
                           id="email"
                           name="email"
                           required>

                    <label>Password</label>

                    <input type="password"
                           id="password"
                           name="password"
                           required>

                    <button type="submit" name="login">
                        Login
                    </button>

                </form>

                <p>
                    New student?
                    <a href="register.php">
                        Create an account
                    </a>
                </p>

            </div>

        </div>

    </div>

</div>

<script src="script.js"></script>

<?php include "footer.php"; ?>