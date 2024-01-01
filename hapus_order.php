<?php
require_once 'config.php';

if (isset($_GET['id'])) {
    $orderId = $_GET['id'];

    // Hapus data order berdasarkan ID
    $deleteResult = $database->orders->deleteOne(['_id' => new MongoDB\BSON\ObjectId($orderId)]);

    if ($deleteResult->getDeletedCount() > 0) {
        echo "Data order berhasil dihapus.";
        header("Location: index.php"); // Redirect ke halaman index setelah penghapusan berhasil
        exit(); // Pastikan tidak ada output lain sebelum redirect
    } else {
        echo "Gagal menghapus data order.";
    }
} else {
    echo "ID order tidak ditemukan.";
}
?>
