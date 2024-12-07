<?php
session_start(); // Start the session

if (isset($_POST["signup"])) {
    require_once "database.php"; // Include your database connection

    $fullName = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordHash = password_hash($password, PASSWORD_BCRYPT); // Hash the password

    $errors = array();

    // Validate the input
    if (empty($fullName) || empty($email) || empty($password)) {
        array_push($errors, "All fields are required");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email");
    }
    if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }

    // Use a prepared statement to check if the email already exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); // Get the result of the query
        
        if (mysqli_num_rows($result) > 0) {
            array_push($errors, "Email already exists");
        }
    }

    // If no errors, insert the new user into the database
    if (count($errors) == 0) {
        $sql = "INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
            mysqli_stmt_execute($stmt);

            // Store session and redirect to index.php after successful registration
            $_SESSION['fullname'] = $fullName;
            header("Location: index.php");
            exit();
        } else {
            array_push($errors, "Error executing query");
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="POST">
            <label for="fullname">Name:</label>
            <input type="text" name="fullname" placeholder="Enter your name" required>
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Enter your email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit" name="signup">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
