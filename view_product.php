<?php
@include 'config.php';
require_once "database.php"; // Include your database connection

// Fetch products from the database
$query = "SELECT * FROM items";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="view_product.css"> <!-- Link to external CSS file -->
</head>
<body>

    <div class="container">
        <h1>Our Products</h1>
        
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
                    <a href="#" class="buy-now-btn">Buy Now</a> <!-- "Buy Now" button -->
                </div>
            <?php } ?>
        </div>
    </div>

</body>
</html>
