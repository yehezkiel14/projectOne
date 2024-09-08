<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include('../db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity']; 
    $image = $_FILES['image']['name'];

    move_uploaded_file($_FILES['image']['tmp_name'], "../img/" . $image);

    $sql = "INSERT INTO products (name, description, price, category, quantity, image) VALUES (:name, :description, :price, :category, :quantity, :image)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([':name' => $name, ':description' => $description, ':price' => $price, ':category' => $category, ':quantity' => $quantity, ':image' => $image])) {
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin: 10px 0 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 16px;
        }
        input[type="file"] {
            border: none;
            margin-bottom: 10px;
        }
        button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #5cb85c;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Product</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" name="name" required>
            <label for="description">Description:</label>
            <textarea name="description" required></textarea>
            <label for="price">Price (IDR):</label>
            <input type="number" name="price" step="1000" required>
            <label for="category">Category:</label>
            <select name="category" required>
                <option value="Dog">Dog</option>
                <option value="Cat">Cat</option>
            </select>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required>
            <label for="image">Image:</label>
            <input type="file" name="image" required>
            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>
