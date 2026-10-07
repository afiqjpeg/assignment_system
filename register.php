<?php

include "db.php";

$error = "";
$success = "";

if (isset($_POST["register"])) {

    $full_name = $_POST["full_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Server-side validation
    if (empty($full_name)) {

        $error = "Full name is required.";

    } elseif (empty($email)) {

        $error = "Email is required.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Invalid email format.";

    } elseif (empty($password)) {

        $error = "Password is required.";

    } elseif (strlen($password) < 6) {

        $error = "Password must be at least 6 characters.";

    } elseif ($password != $confirm_password) {

        $error = "Password does not match.";

    } else {

        // Check email
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $error = "Email already exists.";

        } else {

            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $role = "student";

            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $full_name, $email, $hashedPassword, $role);

            if ($stmt->execute()) {

                $success = "Registration successful.";

            } else {

                $error = "Registration failed.";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">

        <h2>Create Account</h2>

        <?php

        if ($error != "") {
            echo "<p class='error'>$error</p>";
        }

        if ($success != "") {
            echo "<p class='success'>$success</p>";
        }

        ?>

        <form method="post" onsubmit="return validateRegister()">

            <label>Full Name</label>
            <input type="text" id="full_name" name="full_name">

            <label>Email</label>
            <input type="text" id="email" name="email">

            <label>Password</label>
            <input type="password" id="password" name="password">

            <label>Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password">

            <button type="submit" name="register">
                Register
            </button>

        </form>

        <p>
            Already have an account?
            <a href="login.php">Login Here</a>
        </p>

    </div>

    <script src="script.js"></script>

</body>
</html>