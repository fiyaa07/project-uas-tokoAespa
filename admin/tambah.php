<?php
session_start();

// SATPAM: Jika belum login ATAU gelang session-nya BUKAN admin, langsung TENDANG!
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini khusus Admin AÉSPA.'); window.location='../login.php';</script>";
    exit;
}

include '../koneksi.php';

// Proteksi Halaman: Jika belum login, tendang ke login.php
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php");
    exit;
}

include '../koneksi.php';

// Logika pemrosesan form saat tombol submit diklik
if (isset($_POST['simpan'])) {
    $nama_barang = $_POST['nama_barang'];
    $harga       = $_POST['harga'];
    $stok        = $_POST['stok'];
    $deskripsi   = $_POST['deskripsi'];

    // Mengambil data file foto
    $nama_file   = $_FILES['foto']['name'];
    $tmp_name    = $_FILES['foto']['tmp_name'];

    // Menentukan lokasi folder uploads di luar folder admin
    $folder_tujuan = "../uploads/" . $nama_file;

    // Pindahkan file foto ke folder uploads
    if (move_uploaded_file($tmp_name, $folder_tujuan)) {
        // Query simpan data ke database
        $query = "INSERT INTO barang (nama_barang, harga, stok, foto, deskripsi) VALUES ('$nama_barang', '$harga', '$stok', '$nama_file', '$deskripsi')";
        $eksekusi = mysqli_query($koneksi, $query);

        if ($eksekusi) {
            echo "<script>alert('Produk berhasil ditambahkan!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data ke database!');</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload file foto!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Admin - Tambah Barang Baru | AURA.CO</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f9f9f9;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .soft-shadow {
            box-shadow: 0 10px 40px -10px rgba(120, 85, 94, 0.08);
        }
        .focus-ring:focus {
            outline: none;
            border-color: #78555e;
            box-shadow: 0 0 0 3px rgba(120, 85, 94, 0.1);
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-variant": "#e2e2e2",
                        "tertiary-container": "#ffd4c2",
                        "secondary-fixed-dim": "#cfc6b3",
                        "tertiary-fixed-dim": "#edbca6",
                        "surface-container-highest": "#e2e2e2",
                        "on-secondary-container": "#6a6454",
                        "tertiary-fixed": "#ffdbcc",
                        "outline-variant": "#d3c3c5",
                        "error-container": "#ffdad6",
                        "on-secondary": "#ffffff",
                        "secondary-fixed": "#ebe2ce",
                        "on-primary-fixed": "#2d141c",
                        "on-tertiary-container": "#7e5847",
                        "surface-container-low": "#f3f3f4",
                        "outline": "#817476",
                        "tertiary": "#7b5644",
                        "on-primary": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "on-primary-container": "#7a5761",
                        "on-secondary-fixed-variant": "#4c4638",
                        "primary-fixed": "#ffd9e2",
                        "error": "#ba1a1a",
                        "surface-container": "#eeeeee",
                        "surface": "#f9f9f9",
                        "on-tertiary-fixed-variant": "#613e2e",
                        "surface-dim": "#dadada",
                        "inverse-primary": "#e7bbc6",
                        "on-surface": "#1a1c1c",
                        "inverse-on-surface": "#f0f1f1",
                        "on-error-container": "#93000a",
                        "on-tertiary-fixed": "#2f1407",
                        "surface-bright": "#f9f9f9",
                        "primary-fixed-dim": "#e7bbc6",
                        "on-primary-fixed-variant": "#5e3e47",
                        "on-secondary-fixed": "#1f1b0f",
                        "inverse-surface": "#2f3131",
                        "primary-container": "#ffd1dc",
                        "secondary": "#645e4f",
                        "background": "#f9f9f9",
                        "on-background": "#1a1c1c",
                        "secondary-container": "#ebe2ce",
                        "surface-container-high": "#e8e8e8",
                        "on-surface-variant": "#4f4446",
                        "on-error": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "primary": "#78555e",
                        "surface-tint": "#78555e"
                    },
                    "borderRadius": {
                        "DEFAULT": "1rem",
                        "lg": "2rem",
                        "xl": "3rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "container-padding-desktop": "64px",
                        "unit": "4px",
                        "gutter": "24px",
                        "section-gap": "80px",
                        "container-padding-mobile": "20px"
                    },
                    "fontFamily": {
                        "display-lg-mobile": ["Quicksand"],
                        "label-sm": ["Quicksand"],
                        "body-lg": ["Quicksand"],
                        "display-lg": ["Quicksand"],
                        "headline-md": ["Quicksand"],
                        "body-md": ["Quicksand"]
                    },
                    "fontSize": {
                        "display-lg-mobile": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
                    }
                },
            },
        }
    </script>
</head>
<body class="bg-surface text-on-surface min-h-screen flex flex-col">

    <!-- TopNavBar -->
    <header class="w-full top-0 sticky bg-surface dark:bg-surface-dim z-50 shadow-sm">
        <nav class="flex justify-between items-center px-container-padding-mobile md:px-container-padding-desktop h-20 w-full max-w-7xl mx-auto">
            <div class="font-display-lg text-headline-md text-primary dark:text-primary-fixed tracking-tight font-bold">
                AÉSPA
            </div>
            <div class="flex items-center gap-4 text-primary">
                <span class="text-primary font-bold" href="index.php">Admin</span>
                <span class="material-symbols-outlined cursor-pointer hover:scale-105 transition-transform" data-icon="account_circle">account_circle</span>
            </div>
        </nav>
    </header>

    <!-- Main Content Canvas -->
    <main class="flex-grow flex items-center justify-center py-10 px-container-padding-mobile">
        <div class="w-full max-w-2xl bg-surface-container-lowest rounded-lg p-8 md:p-12 soft-shadow border border-secondary-container/30">
            
            <div class="mb-10 text-center">
                <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-2">Tambah Produk Baru</h1>
                <p class="text-on-surface-variant font-body-md">Lengkapi detail produk cardigan terbaru di bawah ini.</p>
            </div>

            <!-- Form PHP dengan Method POST & Enctype berkas -->
            <form class="space-y-6" action="" method="POST" enctype="multipart/form-data">
                
                <!-- Nama Barang -->
                <div class="space-y-2">
                    <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Nama Barang</label>
                    <input name="nama_barang" class="w-full px-5 py-4 rounded-xl border-1.5 border-secondary-container bg-surface focus-ring transition-all text-body-md font-body-md text-on-surface" placeholder="Tulis Produk Terbaru" type="text" required/>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Harga -->
                    <div class="space-y-2">
                        <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Harga (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-primary font-bold">Rp</span>
                            <input name="harga" class="w-full pl-12 pr-5 py-4 rounded-xl border-1.5 border-secondary-container bg-surface focus-ring transition-all text-body-md font-body-md text-on-surface" placeholder="0" type="number" required/>
                        </div>
                    </div>
                    <!-- Stok -->
                    <div class="space-y-2">
                        <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Stok</label>
                        <input name="stok" class="w-full px-5 py-4 rounded-xl border-1.5 border-secondary-container bg-surface focus-ring transition-all text-body-md font-body-md text-on-surface" placeholder="0" type="number" required/>
                    </div>
                </div>

                <!-- Bagian Input Foto Produk (Sudah Diubah dari URL jadi File Upload) -->
                <div class="space-y-2">
                    <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Foto Produk Fisik</label>
                    <div class="relative">
                        <input name="foto" class="w-full px-5 py-4 rounded-xl border-1.5 border-secondary-container bg-surface focus-ring transition-all text-body-md font-body-md text-on-surface" type="file" accept="image/*" required/>
                    </div>
                </div>

                <!-- Deskripsi Barang -->
                <div class="space-y-2">
                    <label class="block font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Deskripsi Barang</label>
                    <textarea name="deskripsi" class="w-full px-5 py-4 rounded-xl border-1.5 border-secondary-container bg-surface focus-ring transition-all text-body-md font-body-md text-on-surface resize-none" placeholder="Jelaskan detail produk dan ukuran..." rows="4" required></textarea>
                </div>

                <!-- Action Buttons Sambungan URL -->
                <div class="flex flex-col md:flex-row gap-4 pt-6">
                    <a href="index.php" class="flex-1 order-2 md:order-1 py-4 rounded-full bg-gray-200 text-gray-700 font-bold hover:bg-gray-300 transition-all text-center flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">arrow_back</span>
                        Kembali
                    </a>
                    <button name="simpan" class="flex-1 order-1 md:order-2 py-4 rounded-full bg-[#4ade80] text-white font-bold shadow-lg shadow-green-200 hover:bg-[#22c55e] transition-all flex items-center justify-center gap-2" type="submit">
                        <span class="material-symbols-outlined text-[20px]">save</span>
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full mt-auto bg-surface-container-lowest dark:bg-surface-container-highest">
        <div class="flex flex-col md:flex-row justify-between items-center py-6 px-container-padding-mobile md:px-container-padding-desktop w-full max-w-7xl mx-auto">
            <div class="font-display-lg text-headline-md text-primary mb-4 md:mb-0 font-bold">
                AÉSPA
            </div>
            <div class="text-on-surface-variant font-body-md text-body-md opacity-80">
                © 2026 AÉSPA. Made with love.
            </div>
        </div>
    </footer>

</body>
</html>