<?php
require_once 'config.php'; // Memanggil file konfigurasi

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customerName'], $_POST['productId'], $_POST['quantity'])) {
    // Ambil data dari formulir
    $customerName = $_POST['customerName'];
    $productId = $_POST['productId'];
    $quantity = (int)$_POST['quantity'];
    $orderDate = date('Y-m-d H:i:s'); // Tambahkan tanggal otomatis saat order dibuat

    // Ambil data produk berdasarkan ID yang dipilih
    $selectedProduct = $productsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($productId)]);
    if (!$selectedProduct) {
        echo "Produk tidak ditemukan.";
        exit;
    }

    // Hitung total harga berdasarkan jumlah yang dimasukkan
    $totalPrice = $selectedProduct->price * $quantity;

    // Menyimpan data ke dalam database
    $newOrder = [
        'customerName' => $customerName,
        'productId' => new MongoDB\BSON\ObjectId($productId),
        'productName' => $selectedProduct->name, // Simpan nama produk
        'quantity' => $quantity,
        'totalPrice' => $totalPrice,
        'orderDate' => new MongoDB\BSON\UTCDateTime(strtotime($orderDate) * 1000) // Ubah ke format UTCDateTime
        // Tambahkan properti lain jika diperlukan
    ];

    // Simpan ke koleksi orders
    $insertResult = $database->orders->insertOne($newOrder);

    if ($insertResult->getInsertedCount() > 0) {
        // Jika berhasil, kembali ke halaman index
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menambahkan data order.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Order</title>
    <style>
        /* ...CSS styling... */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="number"] {
            width: calc(100% - 6px);
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        select {
            width: calc(100% - 12px);
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            /* Tambahkan properti lain jika diperlukan */
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #555;
        }

        a:hover {
            color: #333;
        }

     </style>
</head>
<body>
    <div class="form-container">
        <h1>Tambah Order Baru</h1>
        <form method="post">
            <label for="customerName">Nama Customer:</label>
            <input type="text" id="customerName" name="customerName" required>

            <label for="productId">Pilih Produk:</label>
            <select id="productId" name="productId" required>
                <?php foreach ($productsCollection->find() as $product) : ?>
                    <option value="<?= $product->_id ?>"><?= $product->name ?></option>
                <?php endforeach; ?>
            </select>

            <label for="quantity">Jumlah:</label>
            <input type="number" id="quantity" name="quantity" required>

            <input type="submit" value="Tambah Order">
            <!-- Tombol untuk kembali ke halaman index -->
            <a href="index.php">Kembali ke Halaman Utama</a>
        </form>
    </div>
</body>
</html>
