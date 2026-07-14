<?php
session_start();
include 'koneksi.php';

// Pastikan kamu punya session user atau data checkout. 
// Jika tidak ada data transaksi dinamis, kita buatkan data fallback yang rapi agar tidak error.
$id_pesanan = isset($_SESSION['terakhir_id_pesanan']) ? $_SESSION['terakhir_id_pesanan'] : 'ASP-' . rand(100000, 999999);
$total_pembayaran = isset($_SESSION['terakhir_total']) ? $_SESSION['terakhir_total'] : 458000;
$nama_penerima = isset($_SESSION['penerima_nama']) ? $_SESSION['penerima_nama'] : 'Siska Adelia';
$alamat_penerima = isset($_SESSION['penerima_alamat']) ? $_SESSION['penerima_alamat'] : 'Jl. Melati No. 45, Kebayoran Baru, Jakarta Selatan, 12150';
$metode_bayar = isset($_SESSION['penerima_metode']) ? $_SESSION['penerima_metode'] : 'Virtual Account BCA';

// Setelah sukses, bersihkan isi keranjang belanja agar kosong kembali
if (isset($_SESSION['keranjang'])) {
    unset($_SESSION['keranjang']);
}
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Transaksi Sukses - AÉSPA</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f9f9f9;
            overflow-x: hidden;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .soft-glow {
            box-shadow: 0 20px 40px -15px rgba(120, 85, 94, 0.08);
        }
        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #ffd1dc;
            border-radius: 50%;
            animation: fall linear infinite;
        }
        @keyframes fall {
            0% { transform: translateY(-10vh) rotate(0deg); opacity: 1; }
            100% { transform: translateY(100vh) rotate(360deg); opacity: 0; }
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="text-on-background">

    <div class="fixed inset-0 pointer-events-none z-0" id="confetti-container"></div>

    <nav class="bg-surface w-full top-0 sticky z-50 shadow-sm">
        <div class="flex justify-between items-center px-container-padding-mobile md:px-container-padding-desktop h-20 w-full max-w-7xl mx-auto">
            <span class="font-display-lg text-headline-md text-primary font-bold">AÉSPA</span>
            <div class="flex items-center gap-6">
                <button class="material-symbols-outlined text-primary hover:opacity-80 transition-opacity" onclick="window.location.href='index.php'">close</button>
            </div>
        </div>
    </nav>

    <main class="relative z-10 max-w-4xl mx-auto px-container-padding-mobile md:px-container-padding-desktop py-12">
        
        <section class="text-center mb-section-gap flex flex-col items-center">
            <div class="w-24 h-24 bg-primary-container rounded-full flex items-center justify-center mb-8 animate-bounce cursor-pointer">
                <span class="material-symbols-outlined text-primary text-5xl" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            </div>
            <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-4 font-bold">Terima Kasih, Pesanan Berhasil!</h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg">Pesananmu sudah kami terima dan sedang diproses dengan penuh cinta. Kami akan segera mengirimkannya ke alamat rumahmu.</p>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 gap-gutter mb-section-gap">
            <div class="bg-surface-container-lowest p-8 rounded-lg soft-glow border border-secondary-container/30">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-tertiary">receipt_long</span>
                    <h3 class="font-headline-md text-headline-md text-primary font-bold">Detail Pesanan</h3>
                </div>
                <ul class="space-y-4">
                    <li class="flex justify-between font-body-md text-body-md">
                        <span class="text-on-surface-variant">Nomor Pesanan</span>
                        <span class="font-bold text-on-surface"><?php echo $id_pesanan; ?></span>
                    </li>
                    <li class="flex justify-between font-body-md text-body-md">
                        <span class="text-on-surface-variant">Metode Pembayaran</span>
                        <span class="font-bold text-on-surface"><?php echo $metode_bayar; ?></span>
                    </li>
                    <li class="flex justify-between font-body-md text-body-md">
                        <span class="text-on-surface-variant">Total Pembayaran</span>
                        <span class="font-bold text-primary">Rp <?php echo number_format($total_pembayaran, 0, ',', '.'); ?></span>
                    </li>
                </ul>
            </div>

            <div class="bg-surface-container-lowest p-8 rounded-lg soft-glow border border-secondary-container/30">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-tertiary">local_shipping</span>
                    <h3 class="font-headline-md text-headline-md text-primary font-bold">Pengiriman</h3>
                </div>
                <div class="space-y-2">
                    <p class="font-bold text-on-surface font-body-md text-body-md"><?php echo $nama_penerima; ?></p>
                    <p class="text-on-surface-variant font-body-md text-body-md leading-relaxed">
                        <?php echo nl2br($alamat_penerima); ?>
                    </p>
                    <div class="mt-4 inline-flex items-center gap-2 px-3 py-1 bg-tertiary-fixed rounded-full">
                        <span class="material-symbols-outlined text-on-tertiary-fixed-variant text-sm">schedule</span>
                        <span class="text-label-sm font-label-sm text-on-tertiary-fixed-variant">Estimasi 2-3 hari kerja</span>
                    </div>
                </div>
            </div>
        </section>

        <div class="flex flex-col md:flex-row justify-center gap-6 mb-section-gap">
            <a href="riwayat.php" class="bg-primary text-white px-10 py-4 rounded-full font-bold transition-all hover:scale-105 active:scale-95 soft-glow flex items-center justify-center gap-2 shadow-md">
                Pantau Pesanan
                <span class="material-symbols-outlined">track_changes</span>
            </a>
            <a href="index.php" class="bg-secondary-container text-on-secondary-container border border-tertiary-container px-10 py-4 rounded-full font-bold transition-all hover:scale-105 active:scale-95 flex items-center justify-center gap-2 text-center">
                Kembali ke Beranda
            </a>
        </div>

        <section class="mt-20">
            <div class="flex items-center justify-between mb-8">
                <h2 class="font-headline-md text-headline-md text-primary font-bold">Lihat Cardigan Lucu Lainnya</h2>
                <div class="flex gap-2">
                    <button class="p-2 bg-white rounded-full border border-secondary-container text-primary hover:bg-primary hover:text-white transition-colors" onclick="document.getElementById('reco-scroll').scrollBy({left: -300, behavior: 'smooth'})">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button class="p-2 bg-white rounded-full border border-secondary-container text-primary hover:bg-primary hover:text-white transition-colors" onclick="document.getElementById('reco-scroll').scrollBy({left: 300, behavior: 'smooth'})">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
            </div>

            <div class="flex gap-gutter overflow-x-auto hide-scrollbar pb-8 scroll-smooth snap-x" id="reco-scroll">
                <?php 
                // Ambil 4 produk acak dari database untuk rekomendasi real
                $query_reco = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY RAND() LIMIT 4");
                while ($reco = mysqli_fetch_assoc($query_reco)):
                ?>
                    <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-lg p-4 snap-start soft-glow group border border-gray-100">
                        <div class="aspect-square rounded-lg overflow-hidden mb-4 relative bg-surface-container">
                            <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="uploads/<?php echo $reco['foto']; ?>" alt="<?php echo $reco['nama_barang']; ?>"/>
                            <a href="detail.php?id=<?php echo $reco['id']; ?>" class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm p-3 rounded-full text-primary opacity-0 group-hover:opacity-100 transition-all shadow-lg flex items-center justify-center">
                                <span class="material-symbols-outlined">shopping_cart</span>
                            </a>
                        </div>
                        <div class="text-center">
                            <h4 class="font-bold text-on-surface mb-1"><?php echo $reco['nama_barang']; ?></h4>
                            <p class="text-primary font-bold">Rp <?php echo number_format($reco['harga'], 0, ',', '.'); ?></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </main>

    <footer class="bg-surface-container-lowest dark:bg-surface-container-highest w-full mt-section-gap border-t border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-center py-8 px-container-padding-mobile md:px-container-padding-desktop w-full max-w-7xl mx-auto">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <span class="font-display-lg text-headline-md text-primary font-bold">AÉSPA</span>
                <p class="font-body-md text-body-md text-on-surface-variant mt-2">© 2026 AÉSPA. Made with love.</p>
            </div>
            <div class="flex gap-8">
                <a class="text-on-surface-variant font-body-md text-body-md hover:text-primary transition-colors" href="#">Help</a>
                <a class="text-on-surface-variant font-body-md text-body-md hover:text-primary transition-colors" href="#">Shipping</a>
                <a class="text-on-surface-variant font-body-md text-body-md hover:text-primary transition-colors" href="#">Contact</a>
            </div>
        </div>
    </footer>

    <script>
        // Micro-interaction: Confetti Effect
        function createConfetti() {
            const container = document.getElementById('confetti-container');
            const colors = ['#ffd1dc', '#ffdbcc', '#e7bbc6', '#ebe2ce'];
            
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.classList.add('confetti');
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
                confetti.style.animationDelay = (Math.random() * 2) + 's';
                confetti.style.opacity = Math.random();
                container.appendChild(confetti);

                // Clean up
                setTimeout(() => {
                    confetti.remove();
                }, 5000);
            }
        }

        // Run confetti on load
        window.onload = createConfetti;

        // Re-run confetti on click of the success icon
        document.querySelector('.animate-bounce').onclick = createConfetti;
    </script>
</body>
</html>