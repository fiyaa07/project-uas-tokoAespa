<?php
session_start();

// SATPAM: Jika belum login ATAU gelang session-nya BUKAN admin, langsung TENDANG!
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini khusus Admin AÉSPA.'); window.location='../login.php';</script>";
    exit;
}

include '../koneksi.php';
// Mengambil ID barang yang mau dihapus dari URL
$id = $_GET['id'];

// Mengambil nama file foto lama dari database agar bisa dihapus juga dari laptop
$cari_foto = mysqli_query($koneksi, "SELECT foto FROM barang WHERE id = '$id'");
$data_foto = mysqli_fetch_assoc($cari_foto);
$foto_lama = $data_foto['foto'];

// Menghapus file foto fisik dari folder uploads
if (file_exists("../uploads/" . $foto_lama)) {
    unlink("../uploads/" . $foto_lama);
}

// Menghapus data barang dari database
$query = mysqli_query($koneksi, "DELETE FROM barang WHERE id = '$id'");

if ($query) {
    echo "<script>alert('Barang berhasil dihapus!'); window.location='index.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus barang!'); window.location='index.php';</script>";
}
?>