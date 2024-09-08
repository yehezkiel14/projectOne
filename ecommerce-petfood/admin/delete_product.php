<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}
include('../db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Check if product exists
    $checkSql = "SELECT * FROM products WHERE id = :id";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([':id' => $id]);
    $product = $checkStmt->fetch();

    if ($product) {
        // Delete the product
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([':id' => $id])) {
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid request.";
}
?>
