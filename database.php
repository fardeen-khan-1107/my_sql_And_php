<?php
// Replace with your own database details
$host = 'localhost';
$dbname = 'auth';
$username = 'root'; 
$password = ''; 

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}




// // Create (Insert)
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create"])) {
//     $name = $_POST["name"];
//     $description = $_POST["description"];
//     $price = $_POST["price"];
//     $quantity = $_POST["quantity"];

//     $sql = "INSERT INTO product3 (name, description, price, quantity) VALUES ('$name', '$description', $price, $quantity)";

//     if ($conn->query($sql) === TRUE) {
//         echo "New record created successfully";
//     } else {
//         echo "Error: " . $sql . "<br>" . $conn->error;
//     }
// }



// $sql = "SELECT * FROM product3";
// $result = $conn->query($sql);



// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
//     $id = $_POST["id"];
//     $name = $_POST["name"];
//     $description = $_POST["description"];
//     $price = $_POST["price"];
//     $quantity = $_POST["quantity"];

//     $sql = "UPDATE product3 SET name = '$name', description = '$description', price = $price, quantity = $quantity WHERE id = $id";

//     if ($conn->query($sql) === TRUE) {
//         echo "Record updated successfully";
//     } else {
//         echo "Error updating record: " . $conn->error;
//     }
// }




// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
//     $id = $_POST["id"];

//     $sql = "DELETE FROM product3 WHERE id = $id";

//     if ($conn->query($sql) === TRUE) {
//         echo "Record deleted successfully";
//     } else {
//         echo "Error deleting record: " . $conn->error;
//     }
// }




?>
