<?php
require_once 'config.php'; // Memanggil file konfigurasi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/'; // Direktori tempat menyimpan gambar
    $uploadFile = $uploadDir . basename($_FILES['image']['name']);

    $productData = [
        'name' => $_POST['name'],
        'price' => (float)$_POST['price'],
        'description' => $_POST['description'],
        'image' => $uploadFile // Simpan path gambar ke database
        // Tambahkan properti lain jika diperlukan
    ];

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
        $productsCollection->insertOne($productData);
        header('Location: index.php');
        exit;
    } else {
        echo "Gagal mengunggah gambar.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <style>
        /* Gaya CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 40%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        input[type="file"],
        input[type="submit"],
        .btn-back {
            width: calc(100% - 20px);
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"],
        .btn-back {
            width: 100%;
            background-color: #4285f4;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover,
        .btn-back:hover {
            background-color: #3367d6;
        }

        .btn-back {
            background-color: #ccc;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            width: calc(100% - 20px);
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Produk</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Nama Produk" required><br>
            <input type="number" name="price" placeholder="Harga" step="0.01" required><br>
            <textarea name="description" placeholder="Deskripsi Produk" required></textarea><br>
            <input type="file" name="image" accept="image/*" required><br>
            <input type="submit" value="Tambah">
            
            <!-- Tombol untuk kembali ke halaman utama -->
            <a href="index.php" class="btn-back">Kembali ke Halaman Utama</a>
        </form>
    </div>
</body>
</html>
