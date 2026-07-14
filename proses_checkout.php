<?php
session_start();
include 'koneksi.php';

// Proteksi jika diakses langsung tanpa kirim data form atau keranjang kosong
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    header("Location: index.php");
    exit;
}

// 1. Ambil data inputan dari form checkout kamu
$nama_input = mysqli_real_escape_string($koneksi, $_POST['nama']);
$whatsapp_input = mysqli_real_escape_string($koneksi, $_POST['whatsapp']);
$kota_input = mysqli_real_escape_string($koneksi, $_POST['kota']);
$alamat_input = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$metode_pembayaran = mysqli_real_escape_string($koneksi, $_POST['metode_pembayaran']);

// Gabungkan alamat agar rapi saat ditampilkan di halaman sukses
$alamat_lengkap_penerima = $alamat_input . ", " . $kota_input . " (Telp: " . $whatsapp_input . ")";

// 2. Hitung total bayar murni dari database (menghindari manipulasi harga dari sisi client)
$subtotal = 0;
foreach ($_SESSION['keranjang'] as $id_barang => $jumlah) {
    $query = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id = '$id_barang'");
    $barang = mysqli_fetch_assoc($query);
    if ($barang) {
        $subtotal += ($barang['harga'] * $jumlah);
    }
}

$ongkir = 20000;
$diskon = 50000;
$total_bayar = $subtotal + $ongkir - $diskon;

// 3. Generate ID pesanan unik otomatis (Contoh: ASP-829102)
$id_order_baru_dari_database = 'ASP-' . rand(100000, 999999);

// A. Simpan data induk ke tabel 'pesanan'
$query_pesanan = "INSERT INTO pesanan (id_pesanan, nama_penerima, alamat_penerima, total_bayar, metode_pembayaran) 
                  VALUES ('$id_order_baru_dari_database', '$nama_input', '$alamat_lengkap_penerima', '$total_bayar', '$metode_pembayaran')";
mysqli_query($koneksi, $query_pesanan);

// B. Simpan rincian barang ke tabel 'detail_pesanan' dengan melakukan perulangan isi keranjang
foreach ($_SESSION['keranjang'] as $id_barang => $jumlah) {
    $query_detail = "INSERT INTO detail_pesanan (id_pesanan, id_barang, jumlah) 
                     VALUES ('$id_order_baru_dari_database', '$id_barang', '$jumlah')";
    mysqli_query($koneksi, $query_detail);
}

// C. Setelah berhasil disimpan ke database, kosongkan keranjang belanjaan pembeli
unset($_SESSION['keranjang']);

// 4. MASUKKAN KODE SUNTIKAN SESSION DI SINI
$_SESSION['terakhir_id_pesanan'] = $id_order_baru_dari_database;
$_SESSION['terakhir_total']      = $total_bayar;
$_SESSION['penerima_nama']       = $nama_input;
$_SESSION['penerima_alamat']     = $alamat_lengkap_penerima;
$_SESSION['penerima_metode']     = $metode_pembayaran;

// 5. Alihkan dengan aman ke halaman sukses bawaan desain Stitch kemarin
header("Location: sukses.php");
exit;