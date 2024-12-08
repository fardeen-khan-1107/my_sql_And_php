<?php
@include 'config.php';

if (isset($_POST['submit'])) {
    require_once "database.php"; // Include your database connection
    $product_name = $_POST['productname'];
    $product_description = $_POST['description'];
    $product_price = $_POST['price'];
    $product_quantity = $_POST['quantity'];
    $product_image = $_FILES['image']['name'];
    $product_image_tmp_name = $_FILES['image']['tmp_name'];
    $product_image_folder = 'uploaded_img/' . $product_image;
    // $product_image_folder = $_SERVER['DOCUMENT_ROOT'] . '/project1/uploaded_img/' . $product_image;


    // Check if any of the required fields are empty
    if (empty($product_name) || empty($product_price) || empty($product_image)) {
        $message[] = 'Please fill all details';
    } else {
        // Insert query with all fields (including image path)
        $insert = "INSERT INTO items (name, description, price, quantity, image) VALUES ('$product_name', '$product_description', '$product_price', '$product_quantity', '$product_image')";

        // Execute the insert query
        $upload = mysqli_query($conn, $insert);

        if ($upload) {
            // Move the uploaded file to the desired folder
            if (move_uploaded_file($product_image_tmp_name, $product_image_folder)) {
                $message[] = 'Product added successfully';
            } else {
                $message[] = 'Failed to upload image. Check folder permissions.';
            }
        } else {
            $message[] = 'Could not add the product';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product</title>
  <link rel="stylesheet" href="styles1.css"> <!-- Link to external CSS file -->
</head>
<body>

    <?php
        // Displaying messages
        if (isset($message)) {
            foreach ($message as $msg) {
                echo '<span class="message">' . $msg . '</span>';
            }
        }
    ?>

  <div class="container">
    <h1>Add a Product</h1>
    <form action="addproducts.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="product-name">Product Name:</label>
        <input type="text" id="product-name" name="productname" required>
      </div>

      <div class="form-group">
        <label for="product-description">Product Description:</label>
        <textarea id="product-description" name="description" required></textarea>
      </div>

      <div class="form-group">
        <label for="product-image">Product Image:</label>
        <input type="file" id="product-image" name="image" accept="image/*" required>
      </div>

      <div class="form-group">
        <label for="product-price">Price ($):</label>
        <input type="number" id="product-price" name="price" required>
      </div>

      <div class="form-group">
        <label for="product-quantity">Quantity:</label>
        <input type="number" id="product-quantity" name="quantity" required>
      </div>

      <button type="submit" name="submit">Add Product</button>
    </form>

    <div id="message"></div>
  </div>
</body>
</html>
