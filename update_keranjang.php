<?php
session_start();
include 'koneksi.php';

header('Content-Type: application/json'); // Memastikan browser membaca ini sebagai JSON

if (isset($_POST['id_barang']) && isset($_POST['aksi'])) {
    $id_barang = $_POST['id_barang'];
    $aksi = $_POST['aksi'];

    if (isset($_SESSION['keranjang'][$id_barang])) {
        if ($aksi == 'tambah') {
            $_SESSION['keranjang'][$id_barang]++;
        } elseif ($aksi == 'kurang') {
            if ($_SESSION['keranjang'][$id_barang] > 1) {
                $_SESSION['keranjang'][$id_barang]--;
            }
        }
        
        // Ambil data harga barang dari database
        $query = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id = '$id_barang'");
        $barang = mysqli_fetch_assoc($query);
        
        // HITUNG ANGKA MURNI (Tanpa format Rp atau titik)
        $total_item_baru = (int)$barang['harga'] * $_SESSION['keranjang'][$id_barang];
        
        $subtotal_baru = 0;
        foreach ($_SESSION['keranjang'] as $id => $jumlah) {
            $q_harga = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id = '$id'");
            $b_harga = mysqli_fetch_assoc($q_harga);
            $subtotal_baru += ((int)$b_harga['harga'] * $jumlah);
        }

        // Kirim angka polosan ke JavaScript
        echo json_encode([
            'status' => 'success',
            'kuantitas' => $_SESSION['keranjang'][$id_barang],
            'total_item' => $total_item_baru,
            'subtotal' => $subtotal_baru
        ]);
        exit;
    }
}

echo json_encode(['status' => 'error']);