
<?php
require 'vendor/autoload.php'; // Memuat autoload dari Composer untuk dependencies

// Konfigurasi koneksi MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$database = $mongoClient->furnitureDB; // Menggunakan database furnitureDB
$productsCollection = $database->products; // Koleksi untuk produk
?>
