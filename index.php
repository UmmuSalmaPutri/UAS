<?php
require_once 'config.php'; // Memanggil file konfigurasi

$products = $productsCollection->find();
$orders = $database->orders->find();

$pipeline = [
    [
        '$lookup' => [
            'from' => 'products',
            'localField' => 'productId',
            'foreignField' => '_id',
            'as' => 'product'
        ]
    ],
    [
        '$unwind' => '$product'
    ]
];
$orders = $database->orders->aggregate($pipeline);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Mebel</title>
    <style>
        /* Gaya CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .table-container {
            width: 80%;
            margin-bottom: 20px;
            background-color: #fff;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-container th,
        .table-container td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .table-container th {
            background-color: #f2f2f2;
        }

        .table-container img {
            max-width: 80px;
            max-height: 80px;
            display: block;
            margin: 0 auto;
            /* Membuat gambar menjadi kotak */
            border-radius: 0;
            object-fit: cover;
        }

        .table-container a {
            display: inline-block;
            margin-right: 5px;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 4px;
            background-color: #4285f4;
            color: #fff;
        }

        .table-container a:hover {
            background-color: #3367d6;
        }

        .table-container td a:nth-child(2) {
            background-color: #ea4335;
        }

        .table-container td a:hover:nth-child(2) {
            background-color: #cc372b;
        }

        .table-container a:nth-child(3) {
            background-color: #0f9d58;
        }

        .table-container a:hover:nth-child(3) {
            background-color: #0d8649;
        }

        /* Responsif untuk tampilan mobile */
        @media screen and (max-width: 600px) {
            .table-container {
                width: 100%;
                float: none;
                margin-right: 0;
            }
        }
        </style>
</head>
<body>
    <h1>Data Mebel</h1>

    <div class="table-container">
        <h2>Daftar Produk</h2>

        <!-- Tautan menuju halaman CRUD produk -->
        <a href="tambah_produk.php">Kelola Produk</a>

        <table>
            <tr>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($products as $product) : ?>
                <tr>
                    <td><img src="<?= $product->image ?>" alt="Gambar Produk"></td>
                    <td><?= $product->name ?></td>
                    <td>Rp. <?= $product->price ?></td>
                    <td><?= $product->description ?></td>
                    <!-- Tambahkan kolom aksi -->
                    <td>
                        <a href="edit_produk.php?id=<?= $product->_id ?>">Edit</a>
                        <a href="hapus_produk.php?id=<?= $product->_id ?>">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="table-container">
    <h2>Daftar Order</h2>
        <a href="tambah_order.php">Kelola Order</a>
        <table>
            <tr>
                <th>Nama Customer</th>
                <th>ID Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?= $order->customerName ?></td>
                    <!-- Tampilkan nama produk berdasarkan ID -->
                    <td>
                        <?php
                        $productId = $order->productId;
                        $product = $productsCollection->findOne(['_id' => $productId]);
                        echo $product->name ?? 'Produk tidak ditemukan';
                        ?>
                    </td>
                    <td><?= $order->quantity ?></td>
                    <td><?= $order->totalPrice ?></td>
                    <td>
                        <a href="edit_order.php?id=<?= $order->_id ?>">Edit</a>
                        <a href="hapus_order.php?id=<?= $order->_id ?>">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
