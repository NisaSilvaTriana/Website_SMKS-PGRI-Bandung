<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsentrasi Keahlian - SMKS PGRI Bandung</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Keyframes Animasi Super Smooth */
        @keyframes ultraSmoothUp {
            0% {
                opacity: 0;
                transform: translateY(40px) scale(0.98);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Class Animasi Ekstra Halus */
        .animate-fade-up {
            opacity: 0;
            animation: ultraSmoothUp 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            will-change: transform, opacity;
        }

        .delay-100 { animation-delay: 0.15s; }
        .delay-200 { animation-delay: 0.3s; }
        .delay-300 { animation-delay: 0.45s; }
        .delay-400 { animation-delay: 0.6s; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Navbar -->
    <nav class="bg-white sticky top-0 z-50 shadow-md border-b border-slate-100 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-3">
                <img src="img/logo.png" alt="Logo PGRI" class="w-10 h-10 object-contain shrink-0">
                <div>
                    <h1 class="text-lg font-extrabold text-blue-950 leading-none">SMKS PGRI</h1>
                    <span class="text-[10px] font-bold text-red-600 tracking-wider">BANDUNG</span>
                </div>
            </a>
            <a href="index.php" class="text-xs font-bold text-blue-900 hover:text-red-600 transition flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </nav>

    <!-- Header Banner  -->
    <section class="bg-gradient-to-r from-blue-950 via-blue-900 to-slate-900 text-white py-14 px-4 mb-10 animate-fade-up">
        <div class="max-w-7xl mx-auto text-center">
            <span class="text-yellow-400 text-xs font-extrabold uppercase tracking-widest">Pilihan Masa Depan</span>
            <h1 class="text-3xl sm:text-4xl font-black mt-2">Konsentrasi Keahlian</h1>
            <p class="text-blue-200 text-sm mt-2 max-w-xl mx-auto">Program kejuruan terakreditasi yang dirancang sesuai kebutuhan Industri.</p>
        </div>
    </section>

    <!-- Main Content Grid Kartu -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card MPLB -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm animate-fade-up delay-100 transition duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="w-12 h-12 bg-blue-100 text-blue-900 rounded-xl flex items-center justify-center text-xl font-bold mb-4">
                    <i class="fa-solid fa-building-user"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">MPLB</h3>
                <p class="text-xs font-semibold text-blue-600 mb-2">Manajemen Perkantoran & Layanan Bisnis</p>
                <p class="text-slate-600 text-xs leading-relaxed">Fokus pada tata kelola perkantoran modern, kearsipan digital, dan komunikasi bisnis.</p>
            </div>

            <!-- Card DKV -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm animate-fade-up delay-200 transition duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center text-xl font-bold mb-4">
                    <i class="fa-solid fa-palette"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">DKV</h3>
                <p class="text-xs font-semibold text-red-600 mb-2">Desain Komunikasi Visual</p>
                <p class="text-slate-600 text-xs leading-relaxed">Mempelajari desain grafis, fotografi, videografi, serta Digital Printing modern.</p>
            </div>

            <!-- Card Pemasaran -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm animate-fade-up delay-300 transition duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-xl flex items-center justify-center text-xl font-bold mb-4">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">Pemasaran</h3>
                <p class="text-xs font-semibold text-amber-700 mb-2">Bisnis Digital & Marketing</p>
                <p class="text-slate-600 text-xs leading-relaxed">Keahlian strategi wirausaha, digital marketing, E-Commerce, dan retail.</p>
            </div>

            <!-- Card AKL -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm animate-fade-up delay-400 transition duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center text-xl font-bold mb-4">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">AKL</h3>
                <p class="text-xs font-semibold text-emerald-700 mb-2">Akuntansi & Keuangan Lembaga</p>
                <p class="text-slate-600 text-xs leading-relaxed">Pengelolaan pembukuan keuangan, perbankan syariah, serta akuntansi berbasis komputer.</p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-500 text-xs py-6 border-t border-slate-800 text-center">
        <p>&copy; <?= date('Y') ?> SMKS PGRI Bandung. All Rights Reserved.</p>
    </footer>

</body>
</html>