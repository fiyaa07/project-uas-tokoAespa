<?php
session_start();

// SATPAM: Jika belum login ATAU gelang session-nya BUKAN admin, langsung TENDANG!
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini khusus Admin AÉSPA.'); window.location='../login.php';</script>";
    exit;
}

include '../koneksi.php';
$_SESSION = [];
session_unset();
session_destroy();

echo "<script>alert('Anda telah logout!'); window.location='../login.php';</script>";
exit;
?>