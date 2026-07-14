<?php
session_start();
include 'koneksi.php';

// Jika user sudah login, langsung alihkan ke halaman yang sesuai role-nya
if (isset($_SESSION['login'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin/index.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

$error_login = false;
$active_tab = 'login'; // Tab default saat halaman dimuat

// ==========================================
// 1. LOGIKA PROSES LOG IN (FIXED)
// ==========================================
if (isset($_POST['proses_login'])) {
    $active_tab = 'login';
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query_login = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($query_login) === 1) {
        $user = mysqli_fetch_assoc($query_login);
        
        // Verifikasi kecocokan password terenkripsi menggunakan password_verify
        if (password_verify($password, $user['password'])) {
            // Sesi login diaktifkan
            $_SESSION['login'] = true;
            
            // Perbaikan: Semua diganti menggunakan $user (bukan $row lagi)
            $_SESSION['id_users'] = $user['id']; // Sesuaikan jika nama kolom id kamu di DB adalah 'id' atau 'id_users'
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; 

            // Redirect otomatis sesuai dengan level/role akun
            if ($_SESSION['role'] === 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } // Penutup password_verify yang tadi sempat hilang
    }
    
    // Jika username salah atau password_verify bernilai false
    $error_login = true;
}

// ==========================================
// 2. LOGIKA PROSES REGISTER (SUDAH BENAR)
// ==========================================
if (isset($_POST['proses_register'])) {
    $active_tab = 'register';
    $username = mysqli_real_escape_string($koneksi, $_POST['reg_username']);
    $password = $_POST['reg_password'];
    
    $password_aman = password_hash($password, PASSWORD_DEFAULT);

    // Cek duplikasi username
    $cek_user = mysqli_query($koneksi, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Username sudah terdaftar! Silakan gunakan nama lain.');</script>";
    } else {
        // Akun pendaftar baru dari form ini otomatis diset sebagai 'customer'
        $query_reg = "INSERT INTO users (username, password, role) VALUES ('$username', '$password_aman', 'customer')";
        if (mysqli_query($koneksi, $query_reg)) {
            echo "<script>alert('Registrasi akun berhasil! Silakan langsung login.');</script>";
            $active_tab = 'login'; // Kembalikan fokus tampilan ke tab login
        } else {
            // Jalankan pesan gagal jika ada kendala sistem database
            echo "<script>alert('Registrasi gagal, coba lagi nanti.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Authentication | AURA.CO</title>
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
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f9f9f9; }
        ::-webkit-scrollbar-thumb { background: #ffd1dc; border-radius: 10px; }
        .soft-glow { box-shadow: 0 20px 40px -10px rgba(120, 85, 94, 0.08); }
        .transition-soft { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }
    </style>
</head>
<body class="bg-surface font-body-md text-on-surface selection:bg-primary-container selection:text-on-primary-container">

    <main class="min-h-screen flex flex-col md:flex-row">
        
        <section class="hidden md:flex md:w-1/2 lg:w-3/5 relative overflow-hidden bg-surface-container-low">
            <div class="absolute inset-0 z-0 scale-105 transition-transform duration-1000">
                <div class="w-full h-full bg-cover bg-center" style="background-image: url('https://i.pinimg.com/1200x/c7/55/c2/c755c2b7c5a98dc0f88014ae542df374.jpg')"></div>
            </div>
            <div class="absolute inset-0 z-10 flex flex-col justify-between p-16 bg-gradient-to-t from-black/20 via-transparent to-transparent">
                <div class="flex items-center gap-3 animate-float">
                    <h1 class="font-display-lg text-headline-md text-primary font-bold">AÉSPA</h1>
                </div>
                <div class="max-w-md">
                    <h2 class="font-display-lg text-display-lg text-white mb-4 drop-shadow-sm font-bold">Wrapped in Softness</h2>
                    <p class="font-body-lg text-white/90 leading-relaxed">Experience the gentle embrace of premium Korean knitwear, designed for your most comfortable moments.</p>
                </div>
            </div>
        </section>

        <section class="flex-1 flex flex-col items-center justify-center p-container-padding-mobile md:p-container-padding-desktop bg-surface-container-lowest">
            
            <div class="md:hidden flex flex-col items-center mb-12">
                <span class="material-symbols-outlined text-primary text-5xl mb-2">styler</span>
                <h1 class="font-display-lg-mobile text-display-lg-mobile text-primary italic font-bold">AÉSPA</h1>
            </div>

            <div class="w-full max-w-md space-y-8">
                
                <div class="flex justify-center mb-10">
                    <div class="bg-surface-container-low p-1.5 rounded-full flex gap-1">
                        <button type="button" class="px-8 py-2.5 rounded-full font-medium transition-soft" id="login-tab" onclick="toggleAuth('login')">
                            Login
                        </button>
                        <button type="button" class="px-8 py-2.5 rounded-full font-medium transition-soft" id="register-tab" onclick="toggleAuth('register')">
                            Register
                        </button>
                    </div>
                </div>

                <div class="auth-section space-y-6" id="login-section">
                    <div class="text-center md:text-left">
                        <h3 class="font-display-lg text-headline-md text-on-surface mb-2 font-bold">Welcome Back</h3>
                        <p class="text-on-surface-variant">Sign in to continue your cozy journey.</p>
                    </div>
                    
                    <?php if ($error_login) : ?>
                        <div class="p-4 bg-red-50 text-red-700 text-sm rounded-xl text-center font-semibold border border-red-100">
                            Username atau Password salah!
                        </div>
                    <?php endif; ?>

                    <form class="space-y-4" action="" method="POST">
                        <div>
                            <label class="block text-label-sm text-on-surface-variant mb-2 ml-1" for="username">Username</label>
                            <input name="username" class="w-full px-6 py-4 rounded-xl border-1.5 border-secondary-container bg-surface-container-low focus:ring-2 focus:ring-primary-container focus:border-primary outline-none transition-all" id="username" placeholder="Tulis username Anda" type="text" required/>
                        </div>
                        <div>
                            <label class="block text-label-sm text-on-surface-variant mb-2 ml-1" for="password">Password</label>
                            <input name="password" class="w-full px-6 py-4 rounded-xl border-1.5 border-secondary-container bg-surface-container-low focus:ring-2 focus:ring-primary-container focus:border-primary outline-none transition-all" id="password" placeholder="••••••••" type="password" required/>
                        </div>
                        
                        <button name="proses_login" type="submit" class="w-full bg-primary text-white py-4 rounded-full font-bold text-body-lg soft-glow hover:scale-[1.02] active:scale-[0.98] transition-soft mt-2">
                            Log In
                        </button>
                    </form>
                </div>

                <div class="auth-section hidden space-y-6" id="register-section">
                    <div class="text-center md:text-left">
                        <h3 class="font-display-lg text-headline-md text-on-surface mb-2 font-bold">Create Account</h3>
                        <p class="text-on-surface-variant">Join our community of knitwear lovers.</p>
                    </div>
                    
                    <form class="space-y-4" action="" method="POST">
                        <div>
                            <label class="block text-label-sm text-on-surface-variant mb-2 ml-1" for="reg_username">Username Pendaftaran</label>
                            <input name="reg_username" class="w-full px-6 py-4 rounded-xl border-1.5 border-secondary-container bg-surface-container-low focus:ring-2 focus:ring-primary-container focus:border-primary outline-none transition-all" id="reg_username" placeholder="Buat nama pengguna" type="text" required/>
                        </div>
                        <div>
                            <label class="block text-label-sm text-on-surface-variant mb-2 ml-1" for="reg-password">Password</label>
                            <input name="reg_password" class="w-full px-6 py-4 rounded-xl border-1.5 border-secondary-container bg-surface-container-low focus:ring-2 focus:ring-primary-container focus:border-primary outline-none transition-all" id="reg-password" placeholder="Minimal 8 karakter" type="password" required/>
                        </div>
                        
                        <button name="proses_register" type="submit" class="w-full bg-primary text-white py-4 rounded-full font-bold text-body-lg soft-glow hover:scale-[1.02] active:scale-[0.98] transition-soft mt-2">
                            Sign In
                        </button>
                    </form>
                </div>

                <div class="relative py-4">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-surface-variant"></div></div>
                    <div class="relative flex justify-center text-label-sm uppercase"><span class="bg-surface-container-lowest px-4 text-on-surface-variant">Cozy Boutique Catalog</span></div>
                </div>

            </div>

            <footer class="mt-12 text-center text-label-sm text-on-surface-variant/60">
                <p>© 2026 AÉSPA. Crafted for comfort.</p>
            </footer>
        </section>
    </main>

    <script>
        function toggleAuth(type) {
            const loginSec = document.getElementById('login-section');
            const registerSec = document.getElementById('register-section');
            const loginTab = document.getElementById('login-tab');
            const registerTab = document.getElementById('register-tab');

            if (type === 'login') {
                loginSec.classList.remove('hidden');
                registerSec.classList.add('hidden');
                
                loginTab.className = "px-8 py-2.5 rounded-full font-bold transition-soft bg-surface-container-lowest text-primary soft-glow";
                registerTab.className = "px-8 py-2.5 rounded-full font-medium transition-soft text-on-surface-variant hover:text-primary";
            } else {
                loginSec.classList.add('hidden');
                registerSec.className = "auth-section space-y-6";
                
                registerTab.className = "px-8 py-2.5 rounded-full font-bold transition-soft bg-surface-container-lowest text-primary soft-glow";
                loginTab.className = "px-8 py-2.5 rounded-full font-medium transition-soft text-on-surface-variant hover:text-primary";
            }
        }

        // Jalankan tab aktif bawaan server PHP setelah memproses data
        toggleAuth('<?php echo $active_tab; ?>');

        // Efek interaksi paralaks mouse untuk gambar background kiri
        document.addEventListener('mousemove', (e) => {
            const moveX = (e.clientX - window.innerWidth / 2) * 0.005;
            const moveY = (e.clientY - window.innerHeight / 2) * 0.005;
            const bg = document.querySelector('.scale-105');
            if (bg) {
                bg.style.transform = `scale(1.05) translate(${moveX}px, ${moveY}px)`;
                bg.style.transition = 'transform 0.1s ease-out';
            }
        });
    </script>
</body>
</html>