<?php
session_start();
include('db.php'); // File koneksi ke database

// Memastikan ada produk yang ada di keranjang sebelum di-checkout
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

// Ambil data produk dari session cart
$cartIds = implode(',', array_keys($_SESSION['cart']));
$sql = "SELECT * FROM products WHERE id IN ($cartIds)";
$stmt = $pdo->query($sql);
$cartProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fungsi untuk menghitung total harga pembelian dan mengembalikan dalam format rupiah
function calculateTotalAmount($products) {
    $total = 0;
    foreach ($products as $product) {
        $total += $product['price'] * $_SESSION['cart'][$product['id']];
    }
    return $total;
}

// Validasi dan simpan data pengiriman dan pembayaran jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    // Ambil data pengiriman dari form
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $kode_pos = $_POST['kode_pos'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $total_amount = calculateTotalAmount($cartProducts);
    $created_at = date('Y-m-d H:i:s');

    // Validasi sederhana (bisa diperluas sesuai kebutuhan)
    $errors = [];
    if (empty($nama)) {
        $errors[] = "Nama harus diisi";
    }

    if (empty($alamat)) {
        $errors[] = "Alamat harus diisi";
    }

    if (empty($nomor_telepon)) {
        $errors[] = "Nomor telepon harus diisi";
    }

    if (empty($kode_pos)) {
        $errors[] = "Kode pos harus diisi";
    }

    if (empty($metode_pembayaran)) {
        $errors[] = "Metode pembayaran harus dipilih";
    }

    if (empty($errors)) {
        // Simpan data pengiriman dan pembayaran ke dalam database
        $sql = "INSERT INTO shipping_info (nama, alamat, nomor_telepon, kode_pos, metode_pembayaran, total_amount, created_at) 
                VALUES (:nama, :alamat, :nomor_telepon, :kode_pos, :metode_pembayaran, :total_amount, :created_at)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nama' => $nama,
            ':alamat' => $alamat,
            ':nomor_telepon' => $nomor_telepon,
            ':kode_pos' => $kode_pos,
            ':metode_pembayaran' => $metode_pembayaran,
            ':total_amount' => $total_amount,
            ':created_at' => $created_at
        ]);

        // Mengosongkan session cart setelah checkout
        unset($_SESSION['cart']);

        // Simpan total_amount ke dalam $_SESSION['shipping_info'] untuk digunakan di checkout_success.php
        $_SESSION['shipping_info']['total_amount'] = $total_amount;

        // Redirect ke halaman sukses atau lainnya
        header('Location: checkout_success.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        /* Styling for checkout form */
        .checkout-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .checkout-form label {
            display: block;
            margin-bottom: 10px;
        }

        .checkout-form input[type=text], 
        .checkout-form input[type=tel], 
        .checkout-form select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .checkout-form button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .checkout-form button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <!-- <header>
        <h1>Checkout</h1>
    </header> -->
    <main>
        <div class="checkout-form">
            <h2>Checkout Information</h2>
            <form method="post" action="">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required>

                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" required>

                <label for="nomor_telepon">Nomor Telepon:</label>
                <input type="tel" id="nomor_telepon" name="nomor_telepon" required>

                <label for="kode_pos">Kode Pos:</label>
                <input type="text" id="kode_pos" name="kode_pos" required>

                <label for="metode_pembayaran">Metode Pembayaran:</label>
                <select id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="">Pilih metode pembayaran</option>
                    <option value="cash_on_delivery">Cash on Delivery</option>
                    <option value="credit_card">Kartu Kredit</option>
                </select>

                <?php if (!empty($errors)): ?>
                    <div class="error-message">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <h2>Order Summary</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartProducts as $product): ?>
                            <tr>
                                <td><?php echo $product['name']; ?></td>
                                <td>Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                                <td><?php echo $_SESSION['cart'][$product['id']]; ?></td>
                                <td>Rp <?php echo number_format($product['price'] * $_SESSION['cart'][$product['id']], 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3"><strong>Total Amount:</strong></td>
                            <td><strong>Rp <?php echo number_format(calculateTotalAmount($cartProducts), 0, ',', '.'); ?></strong></td>
                        </tr>
                    </tbody>
                </table>

                <input type="hidden" name="total_amount" value="<?php echo calculateTotalAmount($cartProducts); ?>">
                <button type="submit" name="checkout">Checkout</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 E-Commerce Pet Food. All rights reserved.</p>
    </footer>
</body>
</html>
