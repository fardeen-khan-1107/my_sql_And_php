<?php
@include 'config.php';
require_once "database.php"; // Include your database connection

// If the user is not logged in or not an admin, redirect
session_start();
if (!isset($_SESSION['fullname']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch products from the database
$query = "SELECT * FROM items";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="view_product.css"> <!-- Link to external CSS file -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery for AJAX -->
</head>
<body>

    <div class="container">
        <h1>Manage Products</h1>

        <!-- View All Products -->
        <div class="products-grid">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="product-card">
                    <img src="uploaded_img/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="product-image">
                    <div class="product-details">
                        <h3><?php echo $row['name']; ?></h3>
                        <p><?php echo $row['description']; ?></p>
                        <p class="price">$<?php echo $row['price']; ?></p>
                        <p>Quantity: <?php echo $row['quantity']; ?></p>
                    </div>
                    <!-- Edit and Delete buttons at the bottom of the card -->
                    <div class="product-actions">
                        <a href="update_product.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                        <a href="#" class="btn delete-btn" data-id="<?php echo $row['id']; ?>">Delete</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Handle Delete Product
        $('.delete-btn').click(function(e) {
            e.preventDefault();
            var productId = $(this).data('id');
            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: 'delete_product.php',
                    type: 'GET',
                    data: { delete_id: productId },
                    success: function(response) {
                        alert('Product deleted successfully');
                        location.reload(); // Reload the page to reflect the deletion
                    },
                    error: function(err) {
                        alert('Error deleting product');
                    }
                });
            }
        });
    });
    </script>
</body>
</html>
