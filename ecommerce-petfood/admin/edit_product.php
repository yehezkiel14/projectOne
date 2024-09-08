<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include('../db.php');

$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], "../img/" . $image);
        $sql = "UPDATE products SET name = :name, description = :description, price = :price, image = :image WHERE id = :id";
        $params = [':name' => $name, ':description' => $description, ':price' => $price, ':image' => $image, ':id' => $id];
    } else {
        $sql = "UPDATE products SET name = :name, description = :description, price = :price WHERE id = :id";
        $params = [':name' => $name, ':description' => $description, ':price' => $price, ':id' => $id];
    }

    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($params)) {
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
    <title>Edit Product</title>
</head>
<body>
    <h2>Edit Product</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        <label for="description">Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        <label for="image">Image:</label>
        <input type="file" name="image">
        <button type="submit">Update Product</button>
    </form>
</body>
</html>
