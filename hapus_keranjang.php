<?php
session_start();
$id_barang = $_GET['id'];

// Menghapus item barang terpilih dari session keranjang
unset($_SESSION['keranjang'][$id_barang]);

header("Location: keranjang.php");
exit;
?>