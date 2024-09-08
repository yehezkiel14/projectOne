<?php
session_start();
include('db.php');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Proses jika tombol "Add to Cart" ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $product_id = $_POST['product_id'];

    if ($_POST['action'] == 'add_to_cart') {
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = 1;
        } else {
            $_SESSION['cart'][$product_id]++;
        }
    } elseif ($_POST['action'] == 'remove') {
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
    } elseif ($_POST['action'] == 'increase') {
        // Tambah kuantitas produk
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        }
    } elseif ($_POST['action'] == 'decrease') {
        // Kurangi kuantitas produk, jika kuantitas > 1
        if (isset($_SESSION['cart'][$product_id]) && $_SESSION['cart'][$product_id] > 1) {
            $_SESSION['cart'][$product_id]--;
        }
    }
}

// Ambil data produk dari database untuk ditampilkan di keranjang
$cartProducts = array();
if (!empty($_SESSION['cart'])) {
    $cartIds = implode(',', array_keys($_SESSION['cart']));
    $sql = "SELECT * FROM products WHERE id IN ($cartIds)";
    $stmt = $pdo->query($sql);
    $cartProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Tambahkan kuantitas dari session ke array produk
    foreach ($cartProducts as &$product) {
        $product['quantity'] = $_SESSION['cart'][$product['id']];
    }
}

// Fungsi untuk menghitung total harga pembelian
function calculateTotalAmount($products) {
    $total = 0;
    foreach ($products as $product) {
        $total += $product['price'] * $product['quantity'];
    }
    return $total;
}

// Fungsi untuk format harga menjadi Rupiah
function formatRupiah($price) {
    return 'Rp' . number_format($price, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .product-image {
            width: 50px;
            height: auto;
        }

        .remove-button, .quantity-button {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .remove-button:hover, .quantity-button:hover {
            background-color: #cc0000;
        }

        .quantity-button {
            background-color: #008CBA;
        }

        .quantity-button:hover {
            background-color: #005f73;
        }
    </style>
</head>
<body>
    <header>
        <h1>Shopping Cart</h1>
        <nav>
            <ul>
                <!-- <li><a href="../index.php">Home</a></li>
                <li><a href="../user/logout.php">Logout</a></li> -->
            </ul>
        </nav>
    </header>
    <main>
        <section class="cart">
            <h2>Your Cart</h2>
            <div class="cart-list">
                <?php if (!empty($cartProducts)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartProducts as $product): ?>
                                <tr>
                                    <td><img src="img/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image"></td>
                                    <td><?php echo $product['name']; ?></td>
                                    <td><?php echo formatRupiah($product['price']); ?></td>
                                    <td>
                                        <form method="post" action="" style="display: inline-block;">
                                            <input type="hidden" name="action" value="decrease">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="quantity-button">-</button>
                                        </form>
                                        <?php echo $product['quantity']; ?>
                                        <form method="post" action="" style="display: inline-block;">
                                            <input type="hidden" name="action" value="increase">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="quantity-button">+</button>
                                        </form>
                                    </td>
                                    <td><?php echo formatRupiah($product['price'] * $product['quantity']); ?></td>
                                    <td>
                                        <form method="post" action="">
                                            <input type="hidden" name="action" value="remove">
                                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="remove-button">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="cart-total">
                        <h3>Total Amount: <?php echo formatRupiah(calculateTotalAmount($cartProducts)); ?></h3>
                        <form method="post" action="checkout.php">
                            <input type="hidden" name="total_amount" value="<?php echo calculateTotalAmount($cartProducts); ?>">
                            <button type="submit">Proceed to Checkout</button>
                        </form>
                    </div>
                    <!-- <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a> -->
                <?php else: ?>
                    <p>Your cart is empty.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 E-Commerce Pet Food. All rights reserved.</p>
    </footer>
</body>
</html>
