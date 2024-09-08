<?php
session_start();
include('../db.php');

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];

    $sql = "INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES ('$user_id', '$product_id', '$quantity', '$total_price')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase</title>
</head>
<body>
    <h2>Purchase</h2>
    <form method="post" action="">
        <label for="product_id">Product ID:</label>
        <input type="number" name="product_id" required>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required>
        <label for="total_price">Total Price:</label>
        <input type="number" name="total_price" step="0.01" required>
        <button type="submit">Purchase</button>
    </form>
</body>
</html>
