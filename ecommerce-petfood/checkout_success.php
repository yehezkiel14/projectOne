<?php
session_start();
include('db.php'); // File koneksi ke database

if (empty($_SESSION['shipping_info'])) {
    header('Location: cart.php');
    exit();
}

$cartIds = implode(',', array_keys($_SESSION['cart']));
$sql = "SELECT * FROM products WHERE id IN ($cartIds)";
$stmt = $pdo->query($sql);
$cartProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

function calculateTotalAmount($products) {
    $total = 0;
    foreach ($products as $product) {
        $total += $product['price'] * $_SESSION['cart'][$product['id']];
    }
    return $total;
}

// Simpan data ke database
$nama = $_SESSION['shipping_info']['nama'];
$alamat = $_SESSION['shipping_info']['alamat'];
$nomor_telepon = $_SESSION['shipping_info']['nomor_telepon'];
$kode_pos = $_SESSION['shipping_info']['kode_pos'];
$metode_pembayaran = $_SESSION['shipping_info']['metode_pembayaran'];
$total_amount = $_SESSION['shipping_info']['total_amount']; // Mengambil total_amount dari $_SESSION
$created_at = date('Y-m-d H:i:s');

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

// Ambil ID pesanan yang baru saja dimasukkan
$order_id = $pdo->lastInsertId();

// Hapus session cart dan shipping_info setelah data disimpan
unset($_SESSION['cart']);
unset($_SESSION['shipping_info']);

// Set session variable for success message
$_SESSION['checkout_success'] = true;

// Redirect to a success page or display success message
header('Location: cart.php');
exit();
?>
