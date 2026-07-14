<?php
session_start();
include 'koneksi.php';

// Menghitung jumlah item unik atau total quantity di keranjang belanja
$jumlah_keranjang = 0;
if (isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])) {
    $jumlah_keranjang = array_sum($_SESSION['keranjang']);
}

// Menangani filter kategori secara dinamis via query string (?kategori=xxx)
$kategori_terpilih = isset($_GET['kategori']) ? mysqli_real_escape_string($koneksi, $_GET['kategori']) : 'all';

if ($kategori_terpilih != 'all') {
    // Sesuaikan nama kolom kategori di databasemu jika berbeda (misal: kategori_barang atau deskripsi)
    $query_barang = mysqli_query($koneksi, "SELECT * FROM barang WHERE kategori = '$kategori_terpilih' ORDER BY id DESC");
} else {
    $query_barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html class="light scroll-smooth" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>AÉSPA | Cozy Premium Boutique</title>
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
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .soft-glow {
            box-shadow: 0 10px 40px -10px rgba(120, 85, 94, 0.08);
        }
        .product-card:hover .cart-btn {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="text-on-background">

    <header class="w-full top-0 sticky z-50 bg-surface dark:bg-surface-dim flat no shadows h-20 transition-all duration-300">
        <nav class="flex justify-between items-center px-container-padding-mobile md:px-container-padding-desktop h-full w-full max-w-7xl mx-auto">
            <div class="flex items-center gap-10">
                <a class="font-display-lg text-headline-md text-primary dark:text-primary-fixed font-bold tracking-wider" href="index.php">
                    AÉSPA
                </a>
                
                <div class="hidden md:flex items-center gap-8 pt-1">
                    <a id="menu-shop" class="font-body-md text-body-md pb-1 transition-all text-primary font-bold border-b-2 border-primary" href="index.php">Shop</a>
                    <a id="menu-about" class="font-body-md text-body-md pb-1 transition-all text-on-surface-variant hover:text-primary" href="#about-us">About</a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <form action="index.php" method="GET" class="hidden md:flex items-center bg-surface-container-low px-4 py-2 rounded-full border border-outline-variant/30">
                    <span class="material-symbols-outlined text-on-surface-variant text-[20px] mr-2">search</span>
                    <input name="cari" class="bg-transparent border-none focus:ring-0 text-body-md font-body-md w-32 xl:w-48 placeholder:text-on-surface-variant/50" placeholder="Search cozy..." type="text"/>
                </form>
                
                <div class="flex items-center gap-2">
                    <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true) : ?>
                        <!-- JIKA SUDAH LOGIN -->
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                            <!-- Jika yang login Admin, icon ini mengarah ke Dashboard Manajemen Admin -->
                            <a href="admin/index.php" class="p-2 text-on-surface-variant hover:scale-105 transition-transform" title="Dashboard Admin">
                                <span class="material-symbols-outlined text-primary font-bold">account_circle</span>
                            </a>
                        <?php else : ?>
                            <!-- Jika yang login Customer biasa, icon ini mengarah ke halaman Logout -->
                            <a href="logout.php" class="p-2 text-on-surface-variant hover:scale-105 transition-transform" title="Logout Akun">
                                <span class="material-symbols-outlined">account_circle</span>
                            </a>
                        <?php endif; ?>
                    <?php else : ?>
                        <!-- JIKA BELUM LOGIN, klik icon langsung diarahkan ke halaman login -->
                        <a href="login.php" class="p-2 text-on-surface-variant hover:scale-105 transition-transform" title="Login / Register">
                            <span class="material-symbols-outlined">account_circle</span>
                        </a>
                    <?php endif; ?>
                </div>
                    
                    <a href="keranjang.php" class="p-2 text-on-surface-variant hover:scale-105 transition-transform duration-200 active:scale-95 relative inline-block">
                        <span class="material-symbols-outlined">shopping_bag</span>
                        <?php if ($jumlah_keranjang > 0): ?>
                            <span class="absolute -top-0.5 -right-0.5 bg-primary text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">
                                <?php echo $jumlah_keranjang; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    
                    <button class="md:hidden p-2 text-on-surface-variant">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <main class="max-w-7xl mx-auto">
        <!-- Aesthetic Promo Banner (Full Gambar via Link URL + Edit Langsung di Tempat) -->
<section class="px-container-padding-mobile md:px-container-padding-desktop mt-8 relative group">
    
    <?php
    // 1. Jalankan logika update database langsung di halaman ini jika form dikirim
    // Proteksi tambahan: Hanya jalankan jika yang me-request adalah benar-benar admin
    if (isset($_POST['update_banner_langsung']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        $link_baru = mysqli_real_escape_string($koneksi, $_POST['link_banner']);
        // Cek apakah tabel konfigurasi sudah ada, jika belum kita buat otomatis demi kemudahanmu
        mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS `konfigurasi_toko` (`id` INT PRIMARY KEY, `link_banner` TEXT)");
        mysqli_query($koneksi, "INSERT INTO konfigurasi_toko (id, link_banner) VALUES (1, '$link_baru') ON DUPLICATE KEY UPDATE link_banner='$link_baru'");
        echo "<script>alert('Banner berhasil diperbarui!'); window.location='index.php';</script>";
    }

    // 2. Ambil data banner aktif dari database
    $query_banner = mysqli_query($koneksi, "SELECT link_banner FROM konfigurasi_toko WHERE id = 1");
    $data_banner = mysqli_fetch_assoc($query_banner);
    $link_banner = (!empty($data_banner['link_banner'])) ? $data_banner['link_banner'] : 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105'; 
?>

    <!-- Wadah Banner (Tambahkan class 'group' di pembungkus luar agar efek hover-nya berfungsi) -->
    <div class="relative w-full h-[400px] md:h-[500px] rounded-xl overflow-hidden soft-glow group">
        <img src="<?php echo $link_banner; ?>" 
             class="w-full h-full object-cover transition-transform duration-1000" 
             alt="Promo Banner AÉSPA">
        
        <!-- PENTING: Bungkus tombol dengan pengecekan $_SESSION admin -->
        <?php if (isset($_SESSION['login']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
            <!-- Tombol "Atur Banner" yang HANYA muncul saat kursor diarahkan ke banner & user-nya adalah ADMIN -->
            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-start justify-end p-4">
                <button onclick="bukaModalBanner()" class="bg-white/90 backdrop-blur-sm text-primary hover:bg-primary hover:text-white px-4 py-2 rounded-full text-sm font-semibold flex items-center gap-2 shadow-md transition-all">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    Atur Link Banner
                </button>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ========================================== -->
<!-- MODAL POP-UP UNTUK EDIT LINK (DIPICU JAVASCRIPT) -->
<!-- ========================================== -->
<div id="modalBanner" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4">
    <!-- Backdrop Gelap Belakang Modal -->
    <div onclick="tutupModalBanner()" class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    
    <!-- Kotak Form -->
    <div class="bg-white rounded-xl p-6 w-full max-w-md relative z-10 shadow-xl transition-all scale-95 transform">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Atur Foto Banner</h3>
            <button onclick="tutupModalBanner()" class="text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Masukkan Link URL Gambar Baru:</label>
                <input type="url" name="link_banner" value="<?php echo $link_banner; ?>" required
                       class="w-full px-4 py-2.5 border border-outline-variant rounded-lg focus:ring-2 focus:ring-primary focus:outline-none text-sm" 
                       placeholder="https://pinterest.com/pin/xyz.jpg">
            </div>
            
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="tutupModalBanner()" class="w-1/2 py-2.5 border border-gray-300 text-gray-600 rounded-full font-semibold text-sm hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" name="update_banner_langsung" class="w-1/2 py-2.5 bg-primary text-white rounded-full font-semibold text-sm hover:opacity-90 shadow-md transition-all">
                    Simpan Link
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script Javascript untuk Buka/Tutup Modal -->
<script>
    function bukaModalBanner() {
        const modal = document.getElementById('modalBanner');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('.bg-white').classList.remove('scale-95');
            modal.querySelector('.bg-white').classList.add('scale-100');
        }, 10);
    }

    function tutupModalBanner() {
        const modal = document.getElementById('modalBanner');
        modal.querySelector('.bg-white').classList.remove('scale-100');
        modal.querySelector('.bg-white').classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 150);
    }
</script>

       <section id="koleksi" class="px-container-padding-mobile md:px-container-padding-desktop mt-section-gap">
    <div class="flex flex-col items-center text-center gap-2 border-b border-surface-variant pb-6">
        <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface font-bold">
            The Collection of AÉSPA
        </h2>
        <p class="font-body-md text-body-md text-on-surface-variant">
            Filter by your favorite silhouette
        </p>
    </div>

    <div class="flex flex-wrap justify-center items-center gap-8 mt-6">
        <a href="index.php?kategori=all#koleksi" 
           class="font-body-md text-body-md pb-1 transition-all <?php echo (!isset($_GET['kategori']) || $_GET['kategori'] == 'all') ? 'text-primary font-bold border-b-2 border-primary' : 'text-on-surface-variant hover:text-primary'; ?>">
            All Items
        </a>
    </div>
</section>

        <section class="px-container-padding-mobile md:px-container-padding-desktop mt-12 pb-section-gap">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php 
                if(mysqli_num_rows($query_barang) > 0) {
                    while($row = mysqli_fetch_assoc($query_barang)) { 
                ?>
                        <div class="product-card group flex flex-col bg-surface-container-lowest p-4 rounded-lg soft-glow transition-all duration-300 hover:translate-y-[-8px]">
                            <div class="relative aspect-square rounded-lg overflow-hidden bg-surface mb-6">
                                <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="uploads/<?php echo $row['foto']; ?>" alt="<?php echo $row['nama_barang']; ?>"/>
                                
                                <a href="beli.php?id=<?php echo $row['id']; ?>" class="cart-btn absolute bottom-4 left-4 right-4 bg-on-primary/90 backdrop-blur-md text-primary py-3 rounded-full font-body-md text-body-md flex items-center justify-center gap-2 opacity-0 transform translate-y-4 transition-all duration-300 hover:bg-primary hover:text-on-primary font-semibold">
                                    <span class="material-symbols-outlined text-[20px]">add_shopping_cart</span>
                                    Add to Cart
                                </a>
                            </div>
                            <div class="text-center px-2">
                                <span class="font-label-sm text-label-sm text-tertiary uppercase tracking-widest mb-1 block"><?php echo $row['deskripsi']; ?> Collection</span>
                                <h3 class="font-headline-md text-headline-md text-on-surface mb-1 font-bold"><?php echo $row['nama_barang']; ?></h3>
                                <p class="font-display-lg text-headline-md text-primary font-bold">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></p>
                            </div>
                        </div>
                <?php 
                    }
                } else {
                    echo "<div class='col-span-full py-12 text-center text-on-surface-variant font-body-lg'>Belum ada produk untuk kategori ini.</div>";
                }
                ?>
            </div>
        </section>

        <section class="px-container-padding-mobile md:px-container-padding-desktop mb-section-gap">
            <div class="bg-secondary-container rounded-xl p-12 text-center relative overflow-hidden">
                <div class="relative z-10">
                    <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg text-on-secondary-container mb-4 font-bold">Join the Soft Girl Club</h2>
                    <p class="font-body-lg text-body-lg text-on-secondary-container/80 max-w-lg mx-auto mb-8">Get exclusive access to new arrivals, styling tips, and members-only discounts.</p>
                    <div class="flex flex-col sm:flex-row justify-center items-center gap-4 max-w-md mx-auto">
                        <input class="w-full px-6 py-4 rounded-full border-none focus:ring-2 focus:ring-primary text-body-md" placeholder="Your email address" type="email"/>
                        <button class="w-full sm:w-auto whitespace-nowrap bg-primary text-on-primary px-8 py-4 rounded-full font-headline-md text-headline-md hover:scale-105 transition-transform duration-200 shadow-lg shadow-primary/20 font-bold">
                            Join Now
                        </button>
                    </div>
                </div>
                <div class="absolute -top-24 -right-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-primary/5 rounded-full blur-3xl"></div>
            </div>
        </section>

        <!-- ========================================== -->
        <!-- SECTION ABOUT (PROFIL TOKO AÉSPA)          -->
        <!-- ========================================== -->
        <section id="about-us" class="px-container-padding-mobile md:px-container-padding-desktop mb-section-gap scroll-mt-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center bg-surface-container-lowest p-8 md:p-12 rounded-xl soft-glow">
                
                <!-- Sisi Kiri: Teks Cerita Toko -->
                <div class="space-y-4">
                    <span class="font-label-sm text-label-sm text-tertiary uppercase tracking-widest block">Our Story</span>
                    <h2 class="font-display-lg text-display-lg-mobile md:text-headline-md text-on-surface font-bold">
                        About AÉSPA Boutique
                    </h2>
                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                        Selamat datang di <strong>AÉSPA</strong>, tempat di mana kenyamanan bertemu dengan keindahan visual. Kami percaya bahwa pakaian bukan sekadar apa yang Anda kenakan, melainkan bagaimana Anda mengekspresikan diri dan merasakan kehangatan di setiap momen.
                    </p>
                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
                        Didirikan dengan cinta pada detail estetika, AÉSPA menghadirkan koleksi <em>cozy premium knitwear</em> dan cardigan berkualitas tinggi. Setiap rajutan dirancang dengan teliti untuk memastikan kenyamanan maksimal, penataan desain yang rapi, serta memberikan kesan kasual namun tetap elegan bagi keseharian Anda.
                    </p>
                </div>

                <!-- Sisi Kanan: Visi / Nilai Tambah Toko -->
                <div class="border-l-0 md:border-l-2 border-outline-variant/30 md:pl-12 space-y-6">
                    <div class="flex gap-4 items-start">
                        <span class="material-symbols-outlined text-primary bg-primary-fixed p-3 rounded-full">palette</span>
                        <div>
                            <h4 class="font-body-md font-bold text-on-surface">Creative & Adaptive Design</h4>
                            <p class="text-sm text-on-surface-variant mt-1">Mengikuti tren mode digital terkini dengan sentuhan visual yang unik dan berkarakter.</p>
                        </div>
                    </div>
                    <div class="flex gap-4 items-start">
                        <span class="material-symbols-outlined text-primary bg-primary-fixed p-3 rounded-full">workspace_premium</span>
                        <div>
                            <h4 class="font-body-md font-bold text-on-surface">Meticulous Quality</h4>
                            <p class="text-sm text-on-surface-variant mt-1">Kami sangat teliti dalam pemilihan bahan benang rajut premium demi kenyamanan kulit Anda.</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>

    <footer class="w-full mt-section-gap bg-surface-container-lowest dark:bg-surface-container-highest">
        <div class="flex flex-col md:flex-row justify-between items-center py-8 px-container-padding-mobile md:px-container-padding-desktop w-full border-t border-surface-container">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <a class="font-display-lg text-headline-md text-primary block mb-2 font-bold" href="#">AÉSPA</a>
                <p class="text-tertiary dark:text-tertiary-fixed font-body-md text-body-md">© 2026 AÉSPA. Made with love.</p>
            </div>
            <div class="flex gap-8">
                <a class="text-on-surface-variant font-body-md text-body-md hover:text-primary transition-colors" href="#">Help</a>
                <a class="text-on-surface-variant font-body-md text-body-md hover:text-primary transition-colors" href="#">Shipping</a>
                <a class="text-on-surface-variant font-body-md text-body-md hover:text-primary transition-colors" href="#">Contact</a>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 20) {
                header.classList.add('shadow-sm', 'bg-white/80', 'backdrop-blur-md');
            } else {
                header.classList.remove('shadow-sm', 'bg-white/80', 'backdrop-blur-md');
            }
        });
    </script>
    <script>
        // Ambil elemen menu teks dan section target
        const menuShop = document.getElementById('menu-shop');
        const menuAbout = document.getElementById('menu-about');
        const sectionAbout = document.getElementById('about-us');

        // Fungsi untuk mereset dan memindahkan class aktif
        function setMenuAktif(menuYangAktif) {
            // Class untuk tampilan aktif (Tebal + Garis Bawah)
            const classAktif = ['text-primary', 'font-bold', 'border-b-2', 'border-primary'];
            // Class untuk tampilan biasa (Polos)
            const classBiasa = ['text-on-surface-variant', 'hover:text-primary'];

            if (menuYangAktif === 'about') {
                // Shop jadi polos
                menuShop.classList.remove(...classAktif);
                menuShop.classList.add(...classBiasa);
                // About jadi aktif
                menuAbout.classList.remove(...classBiasa);
                menuAbout.classList.add(...classAktif);
            } else {
                // Shop jadi aktif
                menuShop.classList.remove(...classBiasa);
                menuShop.classList.add(...classAktif);
                // About jadi polos
                menuAbout.classList.remove(...classAktif);
                menuAbout.classList.add(...classBiasa);
            }
        }

        // Jalankan pendeteksi posisi layar scroll
        window.addEventListener('scroll', () => {
            const posisiAbout = sectionAbout.getBoundingClientRect();
            
            // Jika bagian About sudah terlihat di layar (mendekati tengah/atas)
            if (posisiAbout.top <= 150) {
                setMenuAktif('about');
            } else {
                setMenuAktif('shop');
            }
        });

        // Efek klik langsung agar langsung berubah tanpa nunggu scroll selesai
        menuAbout.addEventListener('click', () => setMenuAktif('about'));
        menuShop.addEventListener('click', () => setMenuAktif('shop'));
    </script>
</body>
</html>