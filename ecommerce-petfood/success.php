<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout Success</title>
    <script>
        // Use JavaScript to show an alert with the success message
        window.onload = function() {
            alert("Thank you for your order!\n\nOrder details:\nOrder ID: <?php echo $order_id; ?>\nNama: <?php echo htmlspecialchars($nama); ?>\nAlamat: <?php echo htmlspecialchars($alamat); ?>\nNomor Telepon: <?php echo htmlspecialchars($nomor_telepon); ?>\nKode Pos: <?php echo htmlspecialchars($kode_pos); ?>\nMetode Pembayaran: <?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($metode_pembayaran))); ?>\nTotal Amount: Rp <?php echo number_format($total_amount, 0, ',', '.'); ?>");
            window.location.href = 'brandsDog2.php'; // Redirect to homepage or any other page after displaying alert
        };
    </script>
</head>
<body>
</body>
</html>
