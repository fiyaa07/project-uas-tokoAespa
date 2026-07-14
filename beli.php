<?php
session_start();

// Mengambil ID barang dari URL
$id_barang = $_GET['id'];

// Jika barang sudah ada di keranjang, jumlahnya (quantity) ditambah 1
if (isset($_SESSION['keranjang'][$id_barang])) {
    $_SESSION['keranjang'][$id_barang] += 1;
} else {
    // Jika belum ada, set jumlahnya menjadi 1
    $_SESSION['keranjang'][$id_barang] = 1;
}

// Alihkan langsung ke halaman keranjang belanja
header("Location: keranjang.php");
exit;
?>