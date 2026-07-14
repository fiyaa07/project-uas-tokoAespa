<?php
session_start();

if (!isset($_SESSION['login']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    
    // Jika tidak terdeteksi sebagai admin, tendang keluar ke halaman login
    echo "<script>
            alert('Akses ditolak! Halaman ini hanya untuk Admin.');
            window.location = '../login.php'; 
          </script>";
    exit;
}

// Menghubungkan database kodingan
include '../koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>AÉSPA Admin - Manajemen Barang</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-tint": "#78555e",
                        "on-tertiary": "#ffffff",
                        "surface-container-low": "#f3f3f4",
                        "primary-fixed": "#ffd9e2",
                        "on-primary": "#ffffff",
                        "secondary-fixed": "#ebe2ce",
                        "on-surface-variant": "#4f4446",
                        "on-primary-fixed-variant": "#5e3e47",
                        "on-background": "#1a1c1c",
                        "error-container": "#ffdad6",
                        "tertiary": "#7b5644",
                        "secondary-fixed-dim": "#cfc6b3",
                        "error": "#ba1a1a",
                        "surface-bright": "#f9f9f9",
                        "tertiary-container": "#ffd4c2",
                        "primary": "#78555e",
                        "surface-container": "#eeeeee",
                        "on-error": "#ffffff",
                        "primary-fixed-dim": "#e7bbc6",
                        "on-secondary": "#ffffff",
                        "tertiary-fixed-dim": "#edbca6",
                        "surface-variant": "#e2e2e2",
                        "surface-container-high": "#e8e8e8",
                        "on-tertiary-fixed-variant": "#613e2e",
                        "tertiary-fixed": "#ffdbcc",
                        "on-secondary-container": "#6a6454",
                        "outline-variant": "#d3c3c5",
                        "background": "#f9f9f9",
                        "on-error-container": "#93000a",
                        "inverse-primary": "#e7bbc6",
                        "on-surface": "#1a1c1c",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-container": "#7e5847",
                        "surface-dim": "#dadada",
                        "inverse-on-surface": "#f0f1f1",
                        "primary-container": "#ffd1dc",
                        "surface": "#f9f9f9",
                        "outline": "#817476",
                        "on-primary-container": "#7a5761",
                        "secondary": "#645e4f",
                        "on-primary-fixed": "#2d141c",
                        "on-tertiary-fixed": "#2f1407",
                        "surface-container-highest": "#e2e2e2",
                        "secondary-container": "#ebe2ce",
                        "on-secondary-fixed": "#1f1b0f",
                        "inverse-surface": "#2f3131",
                        "on-secondary-fixed-variant": "#4c4638"
                    },
                    "borderRadius": {
                        "DEFAULT": "1rem",
                        "lg": "2rem",
                        "xl": "3rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "container-padding-desktop": "64px",
                        "container-padding-mobile": "20px",
                        "unit": "4px",
                        "gutter": "24px",
                        "section-gap": "80px"
                    },
                    "fontFamily": {
                        "headline-md": ["Quicksand"],
                        "display-lg-mobile": ["Quicksand"],
                        "body-lg": ["Quicksand"],
                        "label-sm": ["Quicksand"],
                        "display-lg": ["Quicksand"],
                        "body-md": ["Quicksand"]
                    },
                    "fontSize": {
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "display-lg-mobile": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}]
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f9f9f9;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d3c3c5;
            border-radius: 10px;
        }
        .soft-glow {
            box-shadow: 0 20px 40px rgba(120, 85, 94, 0.05);
        }
    </style>
</head>
<body class="bg-background text-on-surface">

    <header class="w-full top-0 sticky z-50 bg-primary-container/80 backdrop-blur-md px-container-padding-desktop py-4 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2">
            <span class="font-headline-md text-headline-md text-on-primary-container tracking-tight font-bold">AÉSPA</span>
        </div>
        <div class="flex items-center gap-6">
            <div class="flex items-center gap-3">
                <a href="../index.php" class="px-6 py-2 rounded-full border border-primary text-primary font-semibold hover:bg-primary/10 transition-all text-body-md font-body-md text-center">
                    Lihat Toko Utama
                </a>
                <a href="logout.php" class="flex items-center gap-2 px-4 py-2 rounded-full bg-secondary text-on-secondary hover:opacity-90 transition-all">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    <span class="font-body-md text-body-md">Logout</span>
                </a>
            </div>
        </div>
    </header>

    <div class="flex min-h-screen">
        <main class="flex-1 px-container-padding-mobile md:px-container-padding-desktop py-10">
            
            <section class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-2">Manajemen Barang</h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">
                        Kelola katalog produk Anda dengan mudah. Tambahkan koleksi terbaru atau perbarui stok barang.
                    </p>
                </div>
                <a href="tambah.php" class="flex items-center gap-2 px-8 py-4 bg-[#d4edda] text-[#155724] rounded-full font-bold text-body-lg hover:scale-[1.02] active:scale-95 transition-all shadow-sm">
                    <span class="material-symbols-outlined">add_circle</span>
                    Tambah Barang Baru
                </a>
            </section>

            <div class="bg-surface-container-lowest rounded-xl overflow-hidden soft-glow border border-outline-variant/20">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-surface-container-low border-b border-outline-variant/30">
                            <tr>
                                <th class="px-6 py-5 font-headline-md text-[14px] text-primary uppercase tracking-wider">No</th>
                                <th class="px-6 py-5 font-headline-md text-[14px] text-primary uppercase tracking-wider">Foto</th>
                                <th class="px-6 py-5 font-headline-md text-[14px] text-primary uppercase tracking-wider">Nama Barang</th>
                                <th class="px-6 py-5 font-headline-md text-[14px] text-primary uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-5 font-headline-md text-[14px] text-primary uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-5 font-headline-md text-[14px] text-primary uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-5 font-headline-md text-[14px] text-primary uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10">
                            
                            <?php 
                            $no = 1;
                            if(mysqli_num_rows($query) > 0) {
                                while($data = mysqli_fetch_assoc($query)) { 
                            ?>
                                <tr class="hover:bg-surface-bright transition-colors group">
                                    <td class="px-6 py-6 font-body-md text-body-md text-on-surface-variant"><?php echo sprintf("%02d", $no++); ?></td>
                                    <td class="px-6 py-6">
                                        <div class="w-20 h-20 rounded-2xl overflow-hidden bg-secondary-container flex-shrink-0">
                                            <img class="w-full h-full object-cover" src="../uploads/<?php echo $data['foto']; ?>" alt="Foto Produk">
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <p class="font-headline-md text-[18px] text-on-surface mb-1"><?php echo $data['nama_barang']; ?></p>
                                        <span class="inline-block px-3 py-1 bg-primary-container text-on-primary-container text-[11px] font-bold rounded-full">KATALOG</span>
                                    </td>
                                    <td class="px-6 py-6 font-headline-md text-[18px] text-primary">Rp <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full <?php echo $data['stok'] > 5 ? 'bg-green-400' : 'bg-orange-400'; ?>"></span>
                                            <span class="font-body-md text-body-md text-on-surface-variant"><?php echo $data['stok']; ?> Pcs</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 max-w-xs">
                                        <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2">
                                            <?php echo $data['deskripsi']; ?>
                                        </p>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="edit.php?id=<?php echo $data['id']; ?>" class="p-3 bg-[#fff3cd] text-[#856404] rounded-xl hover:scale-110 transition-all shadow-sm flex items-center">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                            <a href="hapus.php?id=<?php echo $data['id']; ?>" onclick="return confirm('Yakin ingin menghapus produk cardigan ini?')" class="p-3 bg-[#f8d7da] text-[#721c24] rounded-xl hover:scale-110 transition-all shadow-sm flex items-center">
                                                <span class="material-symbols-outlined">delete</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php 
                                } 
                            } else {
                                echo "<tr><td colspan='7' class='text-center text-muted p-10 font-medium text-gray-400'>Belum ada data cardigan di etalase. Yuk tambah produk baru!</td></tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 bg-surface-container-low border-t border-outline-variant/30 flex items-center justify-between">
                    <p class="font-label-sm text-label-sm text-on-surface-variant">Menampilkan <?php echo mysqli_num_rows($query); ?> jenis produk</p>
                </div>
            </div>
        </main>
    </div>

    <footer class="w-full py-8 flex flex-col items-center justify-center gap-4 bg-surface-container-high/20 mt-auto">
        <p class="font-label-sm text-label-sm text-secondary dark:text-secondary-fixed-dim">© 2026 AÉSPA. Admin Portal — Korean Knitwear Management System</p>
        <div class="w-24 h-1 bg-primary-container rounded-full mt-1"></div>
    </footer>

    <script>
        // Efek animasi lembut saat halaman selesai dimuat
        window.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('tr, header, section');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(10px)';
                el.style.transition = 'all 0.4s ease-out';
                setTimeout(() => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 40);
            });
        });
    </script>
</body>
</html>