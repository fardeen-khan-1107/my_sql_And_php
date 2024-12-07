<?php
session_start(); // Start the session

if (isset($_POST["login"])) {
    require_once "database.php";

    $email = $_POST["email"];
    $password = $_POST["password"];

    $errors = array();

    if (empty($email) || empty($password)) {
        array_push($errors, "Email and Password are required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        // Set session variable and redirect to index.html
        $_SESSION['fullname'] = $user['full_name'];  
        header("Location: index.php");
        exit();
    } else {
        array_push($errors, "Invalid email or password");
    }

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
