<?php
session_start();
include 'koneksi.php';

// Proteksi: Jika keranjang kosong, kembalikan ke halaman utama index.php
if (!isset($_SESSION['keranjang']) || empty($_SESSION['keranjang'])) {
    header("Location: index.php");
    exit;
}

// Set variabel biaya pengiriman dan potongan diskon statis sesuai tampilan mockup Stitch
$ongkir = 20000;
$diskon = 50000; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Checkout | AURA.CO</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background-color: #f9f9f9;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f3f3f4;
        }
        ::-webkit-scrollbar-thumb {
            background: #ffd1dc;
            border-radius: 10px;
        }
        .soft-glow {
            box-shadow: 0 10px 40px -10px rgba(120, 85, 94, 0.08);
        }
        .input-focus:focus {
            outline: none;
            border-color: #78555e;
            box-shadow: 0 0 0 3px rgba(255, 209, 220, 0.5);
        }
        .payment-radio:checked + label {
            border-color: #78555e;
            background-color: #ffd1dc;
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
<body class="bg-background text-on-surface">

    <nav class="w-full top-0 sticky z-50 bg-surface h-20 flex justify-between items-center px-container-padding-mobile md:px-container-padding-desktop max-w-7xl mx-auto">
        <div class="font-display-lg text-headline-md font-bold">AÉSPA</div>
        <div class="flex items-center gap-4">
            <span class="text-on-surface-variant font-body-md hidden md:block">Shopping Securely</span>
            <span class="material-symbols-outlined text-primary" data-icon="lock">lock</span>
        </div>
    </nav>

    <form action="proses_checkout.php" method="POST">
        <main class="max-w-7xl mx-auto px-container-padding-mobile md:px-container-padding-desktop py-gutter md:py-section-gap">
            <div class="flex flex-col lg:flex-row gap-12">
                
                <div class="flex-1 space-y-12">
                    <section>
                        <div class="flex items-center gap-3 mb-8">
                            <span class="material-symbols-outlined text-primary" data-icon="local_shipping">local_shipping</span>
                            <h2 class="font-display-lg text-headline-md text-on-surface">Alamat Pengiriman</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2 space-y-2">
                                <label class="font-label-sm text-on-surface-variant ml-2">Nama Lengkap</label>
                                <input name="nama" class="w-full bg-white border-1.5 border-secondary-container rounded-lg p-4 font-body-md input-focus transition-all" placeholder="Masukkan nama penerima" type="text" required/>
                            </div>
                            <div class="space-y-2">
                                <label class="font-label-sm text-on-surface-variant ml-2">Nomor Telepon</label>
                                <input name="whatsapp" class="w-full bg-white border-1.5 border-secondary-container rounded-lg p-4 font-body-md input-focus transition-all" placeholder="0812xxxx" type="tel" required/>
                            </div>
                            <div class="space-y-2">
                                <label class="font-label-sm text-on-surface-variant ml-2">Kota / Kecamatan</label>
                                <input name="kota" class="w-full bg-white border-1.5 border-secondary-container rounded-lg p-4 font-body-md input-focus transition-all" placeholder="Cari kota..." type="text" required/>
                            </div>
                            <div class="md:col-span-2 space-y-2">
                                <label class="font-label-sm text-on-surface-variant ml-2">Alamat Lengkap</label>
                                <textarea name="alamat" class="w-full bg-white border-1.5 border-secondary-container rounded-lg p-4 font-body-md input-focus transition-all" placeholder="Nama jalan, nomor rumah, detail lainnya" rows="3" required></textarea>
                            </div>
                        </div>
                    </section>

                    <section>
                        <div class="flex items-center gap-3 mb-8">
                            <span class="material-symbols-outlined text-primary" data-icon="account_balance_wallet">account_balance_wallet</span>
                            <h2 class="font-display-lg text-headline-md text-on-surface">Metode Pembayaran</h2>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="relative">
                                <input checked="" class="hidden payment-radio" id="qris" name="metode_pembayaran" value="QRIS" type="radio"/>
                                <label class="flex items-center justify-between p-6 border-2 border-secondary-container rounded-lg cursor-pointer bg-white transition-all hover:scale-[1.01] active:scale-[0.98]" for="qris">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center p-2 shadow-sm">
                                            <span class="material-symbols-outlined text-primary" data-icon="qr_code_2">qr_code_2</span>
                                        </div>
                                        <div>
                                            <div class="font-headline-md text-on-surface text-base">QRIS</div>
                                            <div class="font-label-sm text-on-surface-variant">Instant Payment</div>
                                        </div>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 border-primary flex items-center justify-center">
                                        <div class="w-3 h-3 bg-primary rounded-full"></div>
                                    </div>
                                </label>
                            </div>
                            <div class="relative">
                                <input class="hidden payment-radio" id="ewallet" name="metode_pembayaran" value="E-Wallet" type="radio"/>
                                <label class="flex items-center justify-between p-6 border-2 border-secondary-container rounded-lg cursor-pointer bg-white transition-all hover:scale-[1.01] active:scale-[0.98]" for="ewallet">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center p-2 shadow-sm">
                                            <span class="material-symbols-outlined text-primary" data-icon="smartphone">smartphone</span>
                                        </div>
                                        <div>
                                            <div class="font-headline-md text-on-surface text-base">E-Wallet</div>
                                            <div class="font-label-sm text-on-surface-variant">OVO, GoPay, ShopeePay</div>
                                        </div>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 border-secondary-container flex items-center justify-center">
                                        <div class="w-3 h-3 bg-transparent rounded-full"></div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="w-full lg:w-[400px]">
                    <div class="bg-white rounded-lg p-8 soft-glow sticky top-28 border border-secondary-container">
                        <h3 class="font-display-lg text-headline-md text-on-surface mb-6">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-6 mb-8 max-h-[260px] overflow-y-auto pr-2">
                            <?php 
                            $subtotal = 0;
                            foreach ($_SESSION['keranjang'] as $id_barang => $jumlah): 
                                $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id = '$id_barang'");
                                $barang = mysqli_fetch_assoc($query);
                                $total_item = $barang['harga'] * $jumlah;
                                $subtotal += $total_item;
                            ?>
                                <div class="flex gap-4">
                                    <div class="w-20 h-20 rounded-lg bg-secondary-container overflow-hidden flex-shrink-0">
                                        <div class="w-full h-full bg-cover bg-center" style="background-image: url('uploads/<?php echo $barang['foto']; ?>')"></div>
                                    </div>
                                    <div class="flex flex-col justify-between py-1">
                                        <div class="font-body-md font-semibold text-on-surface leading-tight"><?php echo $barang['nama_barang']; ?></div>
                                        <div class="font-label-sm text-primary"><?php echo $jumlah; ?> Pcs &bull; Knitwear</div>
                                        <div class="font-body-md text-on-surface-variant">Rp <?php echo number_format($barang['harga'], 0, ',', '.'); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="border-t border-dashed border-secondary-container py-6 space-y-3">
                            <div class="flex justify-between font-body-md">
                                <span class="text-on-surface-variant">Subtotal</span>
                                <span class="text-on-surface">Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                            </div>
                            <div class="flex justify-between font-body-md">
                                <span class="text-on-surface-variant">Pengiriman</span>
                                <span class="text-on-surface">Rp <?php echo number_format($ongkir, 0, ',', '.'); ?></span>
                            </div>
                            <div class="flex justify-between font-body-md">
                                <span class="text-on-surface-variant">Diskon Member</span>
                                <span class="text-primary font-bold">-Rp <?php echo number_format($diskon, 0, ',', '.'); ?></span>
                            </div>
                        </div>

                        <div class="border-t-2 border-secondary-container pt-6 mb-8">
                            <div class="flex justify-between items-center">
                                <span class="font-display-lg text-headline-md text-on-surface">Total</span>
                                <span class="font-display-lg text-headline-md text-primary">Rp <?php echo number_format(($subtotal + $ongkir - $diskon), 0, ',', '.'); ?></span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-primary text-white py-4 px-6 rounded-full font-headline-md text-base hover:scale-[1.02] active:scale-[0.97] transition-all soft-glow shadow-primary-fixed/20 flex items-center justify-center gap-2">
                            <span>Bayar Sekarang</span>
                            <span class="material-symbols-outlined text-white" data-icon="arrow_forward">arrow_forward</span>
                        </button>
                        
                        <p class="text-center font-label-sm text-on-surface-variant mt-4">
                            Payments are encrypted and secured.
                        </p>
                    </div>
                </aside>

            </div>
        </main>
    </form>

    <footer class="w-full mt-section-gap bg-surface-container-lowest py-gutter px-container-padding-mobile md:px-container-padding-desktop flex flex-col md:flex-row justify-between items-center border-t border-surface-container">
        <div class="font-display-lg text-headline-md text-primary mb-4 md:mb-0 font-bold">AÉSPA</div>
        <div class="flex gap-8 mb-4 md:mb-0">
            <a class="font-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Help</a>
            <a class="font-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Shipping</a>
            <a class="font-body-md text-on-surface-variant hover:text-primary transition-colors" href="#">Contact</a>
        </div>
        <div class="font-body-md text-on-surface-variant">© 2026 AÉSPA. Made with love.</div>
    </footer>

    <script>
        document.querySelectorAll('input[name="metode_pembayaran"]').forEach(input => {
            input.addEventListener('change', (e) => {
                document.querySelectorAll('.payment-radio + label').forEach(label => {
                    label.style.borderColor = '#ebe2ce'; 
                    label.querySelector('.w-6.h-6').style.borderColor = '#ebe2ce';
                    label.querySelector('.w-3.h-3').style.backgroundColor = 'transparent';
                });
                
                if (e.target.checked) {
                    const label = e.target.nextElementSibling;
                    label.style.borderColor = '#78555e'; 
                    const indicator = label.querySelector('.w-6.h-6');
                    indicator.style.borderColor = '#78555e';
                    indicator.querySelector('.w-3.h-3').style.backgroundColor = '#78555e';
                }
            });
        });

        document.querySelectorAll('.flex.gap-4').forEach(item => {
            item.addEventListener('mouseenter', () => {
                const imgContainer = item.querySelector('.rounded-lg');
                if (imgContainer) imgContainer.style.transform = 'scale(1.05)';
            });
            item.addEventListener('mouseleave', () => {
                const imgContainer = item.querySelector('.rounded-lg');
                if (imgContainer) imgContainer.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>