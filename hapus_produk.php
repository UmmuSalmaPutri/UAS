<?php
// File: hapus_produk.php
require_once 'config.php'; // Memanggil file konfigurasi

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $productId = new MongoDB\BSON\ObjectId($_GET['id']);

    $productsCollection->deleteOne(['_id' => $productId]);
    header('Location: index.php');
    exit;
}
?>
