<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: adminLogin.php");
    exit;
}
include('../db.php');

// Check if deletion was successful
$deleted = false;
if (isset($_GET['delete'])) {
    $deleted = $_GET['delete'] === 'success';
}

// Fetch orders data from shipping_info table
$orders = [];
$sql = "SELECT * FROM shipping_info ORDER BY id DESC";
$stmt = $pdo->query($sql);

if ($stmt) {
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $errorInfo = $pdo->errorInfo();
    echo "Error: " . $errorInfo[2]; // Display the error message
}

// Function to format price as Rupiah
function formatRupiah($price) {
    return 'Rp' . number_format($price, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        h2, h3, h4 {
            text-align: center;
            color: #333;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            background-color: #dff0d8;
            border: 1px solid #d6e9c6;
            color: #3c763d;
            border-radius: 4px;
            text-align: center;
        }
        .form-container {
            max-width: 1000px;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f9f9f9;
        }
        a {
            color: #337ab7;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        img {
            max-width: 50px;
            height: auto;
        }
        .actions a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></h2>
        <p>
            <a href="add_product.php">Add Product</a> | 
            <a href="logout.php">Logout</a>
        </p>

        <!-- Display success message if product deleted -->
        <?php if ($deleted): ?>
            <div class="message">Product deleted successfully.</div>
        <?php endif; ?>

        <h3>Manage Products</h3>

        <!-- Display products for Dogs -->
        <h4>Dog Products</h4>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            $sqlDog = "SELECT * FROM products WHERE category = 'Dog'";
            $stmtDog = $pdo->query($sqlDog);

            while ($row = $stmtDog->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['description']}</td>
                    <td>" . formatRupiah($row['price']) . "</td>
                    <td>{$row['quantity']}</td>
                    <td><img src='../img/{$row['image']}'></td>
                    <td class='actions'>
                        <a href='edit_product.php?id={$row['id']}'>Edit</a>
                        <a href='delete_product.php?id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>
                    </td>
                </tr>";
            }
            ?>
        </table>

        <!-- Display products for Cats -->
        <h4>Cat Products</h4>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            $sqlCat = "SELECT * FROM products WHERE category = 'Cat'";
            $stmtCat = $pdo->query($sqlCat);

            while ($row = $stmtCat->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['description']}</td>
                    <td>" . formatRupiah($row['price']) . "</td>
                    <td>{$row['quantity']}</td>
                    <td><img src='../img/{$row['image']}'></td>
                    <td class='actions'>
                        <a href='edit_product.php?id={$row['id']}'>Edit</a>
                        <a href='delete_product.php?id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a>
                    </td>
                </tr>";
            }
            ?>
        </table>

        <!-- Display orders -->
        <h3>Manage Orders</h3>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Nomor Telepon</th>
                <th>Kode Pos</th>
                <th>Total Amount</th>
                <th>Metode Pembayaran</th>
                <th>Order Time</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo htmlspecialchars($order['nama']); ?></td>
                    <td><?php echo htmlspecialchars($order['alamat']); ?></td>
                    <td><?php echo htmlspecialchars($order['nomor_telepon']); ?></td>
                    <td><?php echo htmlspecialchars($order['kode_pos']); ?></td>
                    <td><?php echo formatRupiah($order['total_amount']); ?></td>
                    <td><?php echo htmlspecialchars(ucfirst($order['metode_pembayaran'])); ?></td>
                    <td><?php echo date('d-m-Y H:i:s', strtotime($order['created_at'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
