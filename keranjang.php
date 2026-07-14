<?php
session_start();
include 'koneksi.php';

// Cek apakah keranjang kosong atau belum diset
if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    $keranjang_kosong = true;
} else {
    $keranjang_kosong = false;
}
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Keranjang Belanja - AURA.CO</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Quicksand', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .soft-shadow {
            box-shadow: 0 10px 40px -10px rgba(120, 85, 94, 0.08);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
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
<body class="bg-surface text-on-surface">

    <header class="w-full top-0 sticky z-50 bg-surface dark:bg-surface-dim shadow-sm">
        <div class="flex justify-between items-center px-container-padding-mobile md:px-container-padding-desktop h-20 w-full max-w-7xl mx-auto">
            <a class="font-display-lg text-headline-md text-primary dark:text-primary-fixed font-bold" href="index.php">AÉSPA</a>
            <div class="flex items-center space-x-4">
                <a href="admin/index.php" class="p-2 text-on-surface-variant hover:text-primary transition-all">
                    <span class="material-symbols-outlined">account_circle</span>
                </a>
                <button class="p-2 text-primary font-bold border-b-2 border-primary pb-1 relative transition-all">
                    <span class="material-symbols-outlined">shopping_bag</span>
                    <span id="badge-keranjang" class="absolute -top-1 -right-1 bg-primary text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center">
                        <?php echo !$keranjang_kosong ? array_sum($_SESSION['keranjang']) : '0'; ?>
                    </span>
                </button>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-container-padding-mobile md:px-container-padding-desktop py-12">
        <nav class="mb-8 flex items-center text-label-sm text-on-surface-variant space-x-2">
            <a class="hover:text-primary" href="index.php">Beranda</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-primary font-semibold">Keranjang Belanja</span>
        </nav>
        
        <?php if ($keranjang_kosong): ?>
            <div class="bg-surface-container-lowest rounded-xl p-16 text-center border border-dashed border-outline-variant/50 max-w-2xl mx-auto soft-shadow">
                <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">shopping_cart_off</span>
                <h3 class="text-xl font-bold text-gray-700 mb-2">Keranjang Anda Masih Kosong</h3>
                <p class="text-gray-400 mb-8 text-sm">Yuk, kembali ke toko dan temukan berbagai pilihan cardigan rajut menarik favoritmu!</p>
                <a href="index.php" class="px-8 py-3.5 bg-primary text-white font-bold rounded-full shadow-md hover:opacity-95 transition-all"> Kembali Belanja </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter lg:gap-12 items-start">
                
                <div class="lg:col-span-8 space-y-6">
                    <?php 
                    $subtotal = 0;
                    foreach ($_SESSION['keranjang'] as $id_barang => $jumlah): 
                        $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id = '$id_barang'");
                        $barang = mysqli_fetch_assoc($query);
                        $total_item = $barang['harga'] * $jumlah;
                        $subtotal += $total_item;
                    ?>
                        <div class="bg-surface-container-lowest rounded-lg p-6 flex flex-col sm:flex-row items-center gap-6 soft-shadow border border-secondary-container/30 group relative transition-all">
                            <a href="hapus_keranjang.php?id=<?php echo $id_barang; ?>" class="absolute top-4 right-4 text-gray-400 hover:text-error transition-colors">
                                <span class="material-symbols-outlined text-xl">delete</span>
                            </a>

                            <div class="w-32 h-40 flex-shrink-0 rounded-lg overflow-hidden bg-primary-container/20">
                                <img class="w-full h-full object-cover" src="uploads/<?php echo $barang['foto']; ?>" alt="Foto Produk"/>
                            </div>
                            <div class="flex-grow text-center sm:text-left w-full">
                                <h3 class="font-headline-md text-headline-md text-on-surface mb-1 font-bold"><?php echo $barang['nama_barang']; ?></h3>
                                <p class="text-body-md text-on-surface-variant mb-4">Kategori: Premium Knitwear</p>
                                
                                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                    <div class="flex items-center bg-surface-container rounded-full px-3 py-1.5 gap-3">
                                        <button type="button" onclick="ubahKuantitas('<?php echo $id_barang; ?>', 'kurang', this)" class="w-7 h-7 flex items-center justify-center font-bold text-on-surface-variant hover:bg-primary hover:text-white rounded-full transition-colors">-</button>
                                        <span class="font-bold text-sm text-on-surface w-6 text-center kuantitas-barang id-barang-<?php echo $id_barang; ?>"><?php echo $jumlah; ?></span>
                                        <button type="button" onclick="ubahKuantitas('<?php echo $id_barang; ?>', 'tambah', this)" class="w-7 h-7 flex items-center justify-center font-bold text-on-surface-variant hover:bg-primary hover:text-white rounded-full transition-colors">+</button>
                                    </div>

                                    <span class="font-headline-md text-primary font-bold total-item-<?php echo $id_barang; ?>">
                                        Rp <?php echo number_format($total_item, 0, ',', '.'); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="bg-primary-container/30 rounded-lg p-6 border border-primary-container flex flex-col md:flex-row items-center gap-4">
                        <span class="material-symbols-outlined text-primary text-3xl">redeem</span>
                        <div class="flex-grow text-center md:text-left">
                            <h4 class="font-bold text-on-primary-container">Gunakan Kode Promo</h4>
                            <p class="text-on-primary-fixed-variant text-sm">Dapatkan potongan harga untuk pesanan pertama Anda.</p>
                        </div>
                        <div class="flex w-full md:w-auto bg-surface-container-lowest rounded-full border border-primary-container overflow-hidden">
                            <input class="bg-transparent border-none focus:ring-0 px-4 py-2 w-full md:w-32 text-sm" placeholder="Masukkan kode" type="text"/>
                            <button type="button" class="bg-primary text-white px-6 py-2 font-semibold hover:opacity-90">Pakai</button>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-32 w-full">
                    <div class="bg-surface-container-lowest rounded-lg p-8 soft-shadow border border-secondary-container/30">
                        <h3 class="font-headline-md text-headline-md text-on-surface mb-8 font-bold">Ringkasan Pesanan</h3>
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between items-center text-body-md text-on-surface-variant">
                                <span>Subtotal</span>
                                <span id="text-subtotal" class="font-semibold text-gray-800">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                            </div>
                            <div class="flex justify-between items-center text-body-md text-on-surface-variant">
                                <span>Pengiriman</span>
                                <span class="text-primary font-medium">Gratis</span>
                            </div>
                            <div class="flex justify-between items-center text-body-md text-on-surface-variant">
                                <span>Diskon</span>
                                <span class="text-gray-800">- Rp 0</span>
                            </div>
                            <div class="pt-4 border-t border-surface-container flex justify-between items-center">
                                <span class="font-bold text-on-surface">Total</span>
                                <span id="text-total" class="font-display-lg text-headline-md text-primary font-bold">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                            </div>
                        </div>
                        
                        <a href="checkout.php" class="w-full bg-primary text-white font-bold py-4 rounded-full flex items-center justify-center gap-2 hover:scale-[1.02] transition-transform shadow-md text-center">
                            Lanjut ke Checkout
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                        
                        <p class="text-center text-label-sm text-on-surface-variant mt-6 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[16px]">lock</span>
                            Pembayaran Aman & Terenkripsi
                        </p>
                    </div>

                    <div class="p-6 bg-tertiary-fixed-dim/20 rounded-lg flex items-center gap-4 border border-tertiary-fixed-dim/30 animate-float">
                        <span class="material-symbols-outlined text-tertiary flex-shrink-0">favorite</span>
                        <p class="text-body-md text-on-tertiary-fixed-variant text-sm leading-relaxed">
                            Setiap pembelian membantu mendukung perajin lokal di Indonesia.
                        </p>
                    </div>
                </div>

            </div>
        <?php endif; ?>
    </main>

    <footer class="w-full mt-section-gap bg-surface-container-lowest dark:bg-surface-container-highest border-t border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-center py-8 px-container-padding-mobile md:px-container-padding-desktop w-full max-w-7xl mx-auto">
            <div class="flex flex-col items-center md:items-start mb-6 md:mb-0">
                <span class="font-display-lg text-headline-md text-primary mb-2 font-bold">AÉSPA</span>
                <p class="text-on-surface-variant font-body-md text-body-md">© 2026 AÉSPA. Made with love.</p>
            </div>
            <div class="flex space-x-8">
                <a class="text-on-surface-variant font-body-md text-body-md hover:text-primary transition-colors" href="#">Help</a>
                <a class="text-on-surface-variant font-body-md text-body-md hover:text-primary transition-colors" href="#">Shipping</a>
                <a class="text-on-surface-variant font-body-md text-body-md hover:text-primary transition-colors" href="#">Contact</a>
            </div>
        </div>
    </footer>

<script>
// Fungsi JavaScript untuk memformat angka menjadi Rupiah (Rp xx.xxx)
function formatRupiah(angka) {
    return 'Rp ' + new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(angka);
}

function ubahKuantitas(idBarang, aksi, button) {
    let formData = new FormData();
    formData.append('id_barang', idBarang);
    formData.append('aksi', aksi);

    fetch('update_keranjang.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // 1. Update angka kuantitas barang di card
            document.querySelector('.id-barang-' + idBarang).innerText = data.kuantitas;
            
            // 2. Update total harga produk tersebut dengan format rupiah bersih
            document.querySelector('.total-item-' + idBarang).innerText = formatRupiah(data.total_item);
            
            // 3. Update Ringkasan Pesanan (Subtotal & Total)
            document.getElementById('text-subtotal').innerText = formatRupiah(data.subtotal);
            document.getElementById('text-total').innerText = formatRupiah(data.subtotal);

            // 4. Update Angka Badge Keranjang yang ada di navbar atas secara realtime
            let totalBarang = 0;
            document.querySelectorAll('.kuantitas-barang').forEach(el => {
                totalBarang += parseInt(el.innerText) || 0;
            });
            document.getElementById('badge-keranjang').innerText = totalBarang;
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
</body>
</html>