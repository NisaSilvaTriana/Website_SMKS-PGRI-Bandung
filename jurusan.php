<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konsentrasi Keahlian - SMKS PGRI Bandung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <nav class="bg-white sticky top-0 z-50 shadow-md border-b border-slate-100 py-3">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-3">
                <img src="img/logo.png" alt="Logo PGRI" class="w-10 h-10 object-contain">
                <span class="font-extrabold text-blue-950">SMKS PGRI BANDUNG</span>
            </a>
            <a href="index.php" class="text-xs font-bold text-blue-900 hover:underline">&larr; Kembali ke Beranda</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 py-16">
        <div class="text-center max-w-2xl mx-auto mb-14">
            <span class="text-red-600 text-xs font-bold uppercase tracking-widest">Pilihan Masa Depan</span>
            <h1 class="text-3xl font-extrabold text-blue-950 mt-1">Konsentrasi Keahlian</h1>
            <p class="text-slate-600 text-sm mt-2">Program kejuruan terakreditasi yang dirancang sesuai kebutuhan Industri.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="w-12 h-12 bg-blue-100 text-blue-900 rounded-xl flex items-center justify-center text-xl font-bold mb-4">
                    <i class="fa-solid fa-building-user"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">MPLB</h3>
                <p class="text-xs font-semibold text-blue-600 mb-2">Manajemen Perkantoran & Layanan Bisnis</p>
                <p class="text-slate-600 text-xs leading-relaxed">Fokus pada tata kelola perkantoran modern, kearsipan digital, dan komunikasi bisnis.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center text-xl font-bold mb-4">
                    <i class="fa-solid fa-palette"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">DKV</h3>
                <p class="text-xs font-semibold text-red-600 mb-2">Desain Komunikasi Visual</p>
                <p class="text-slate-600 text-xs leading-relaxed">Mempelajari desain grafis, fotografi, videografi, serta Digital Printing modern.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-xl flex items-center justify-center text-xl font-bold mb-4">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">Pemasaran</h3>
                <p class="text-xs font-semibold text-amber-700 mb-2">Bisnis Digital & Marketing</p>
                <p class="text-slate-600 text-xs leading-relaxed">Keahlian strategi wirausaha, digital marketing, E-Commerce, dan retail.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center text-xl font-bold mb-4">
                    <i class="fa-solid fa-calculator"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">AKL</h3>
                <p class="text-xs font-semibold text-emerald-700 mb-2">Akuntansi & Keuangan Lembaga</p>
                <p class="text-slate-600 text-xs leading-relaxed">Pengelolaan pembukuan keuangan, perbankan syariah, serta akuntansi berbasis komputer.</p>
            </div>
        </div>
    </main>

</body>
</html>