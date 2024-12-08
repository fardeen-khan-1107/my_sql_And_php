<?php
session_start(); // Start the session

if (isset($_POST["login"])) {
    require_once "database.php"; // Include your database connection

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Predefined admin credentials
    $admin_email = 'admin@gmail.com';  // You can change this to the email you want for admin
    $admin_password = '98898816';  // Predefined admin password

    $errors = array();

    // Validate input fields
    if (empty($email) || empty($password)) {
        array_push($errors, "Email and Password are required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }

    // Check if admin login credentials are correct
    if ($email === $admin_email && $password === $admin_password) {
        $_SESSION['role'] = 'admin';  // Set session variable to indicate admin login
        $_SESSION['username'] = $email;  // Store the email for the session
        header("Location: view_admin.php");  // Redirect to the products page for admin
        exit();
    } else {
        // Use prepared statement to prevent SQL injection for normal user login
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $user = mysqli_fetch_assoc($result);

            // Verify the password if user is found
            if ($user && password_verify($password, $user['password'])) {
                // Set session variable and redirect to index.php for normal users
                $_SESSION['role'] = 'user';  // Set session role as user
                $_SESSION['username'] = $email;  // Store the email for the session
                $_SESSION['fullname'] = $user['full_name'];  
                header("Location: index.php");  // Redirect to homepage
                exit();
            } else {
                array_push($errors, "Invalid email or password");
            }
        } else {
            array_push($errors, "Error preparing query");
        }
    }

    // Display errors if any
    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='error'>$error</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Enter your email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
    </div>
</body>
</html>
