
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Dashboard</title>
</head>
<body>
    <?php
include("protect.php");  // Protect the route
?>
    <h1>Welcome to the Dashboard</h1>
    <p>Hello <?php echo $_SESSION['fullname']; ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>
