<?php
@include 'config.php';
require_once "database.php"; // Include your database connection

// If the user is not logged in or not an admin, redirect
session_start();
if (!isset($_SESSION['fullname']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Check if a product ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the product details based on the ID
    $query = "SELECT * FROM items WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $product = mysqli_fetch_assoc($result);

        // If the product doesn't exist, redirect back
        if (!$product) {
            echo "Product not found!";
            exit();
        }
    } else {
        echo "Error preparing statement.";
        exit();
    }
} else {
    echo "No product ID provided!";
    exit();
}

// Handle form submission to update the product
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Update the product in the database
    $update_query = "UPDATE items SET name = ?, description = ?, price = ?, quantity = ? WHERE id = ?";
    $update_stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($update_stmt, $update_query)) {
        mysqli_stmt_bind_param($update_stmt, "ssiii", $name, $description, $price, $quantity, $product_id);
        if (mysqli_stmt_execute($update_stmt)) {
            // Redirect back to manage_products.php after update
            header("Location: manage_products.php");
            exit();
        } else {
            echo "Error updating product.";
        }
    } else {
        echo "Error preparing update statement.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <link rel="stylesheet" href="view_product.css"> <!-- Link to external CSS file -->
</head>
<body>

    <div class="container">
        <h1>Update Product</h1>

        <!-- Product Update Form -->
        <form action="update_product.php?id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
            <label for="name">Product Name</label>
            <input type="text" name="name" value="<?php echo $product['name']; ?>" required>

            <label for="description">Product Description</label>
            <textarea name="description" required><?php echo $product['description']; ?></textarea>

            <label for="price">Price</label>
            <input type="number" name="price" value="<?php echo $product['price']; ?>" required>

            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" required>

            <button type="submit" name="update">Update Product</button>
        </form>
    </div>

</body>
</html>
