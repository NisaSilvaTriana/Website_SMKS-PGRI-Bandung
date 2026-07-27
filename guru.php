<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guru & Staff - SMKS PGRI Bandung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

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

        .animate-fade-up {
            opacity: 0;
            animation: ultraSmoothUp 1.2s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            will-change: transform, opacity;
        }

        .delay-100 { animation-delay: 0.15s; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

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

    <section class="bg-gradient-to-r from-blue-950 via-blue-900 to-slate-900 text-white py-20 px-4 mb-10 animate-fade-up">
        <div class="max-w-7xl mx-auto text-center">
            <span class="text-yellow-400 text-xs font-extrabold uppercase tracking-widest">Tenaga Pendidik</span>
            <h1 class="text-3xl sm:text-4xl font-black mt-2">Guru & Staff Pengajar</h1>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 animate-fade-up delay-100">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            <?php
            $query_guru = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY id ASC");
            if (mysqli_num_rows($query_guru) > 0) {
                while ($g = mysqli_fetch_assoc($query_guru)) {
                    $foto = (!empty($g['foto']) && file_exists($g['foto'])) ? $g['foto'] : 'img/default.jpg';
            ?>
                <div class="bg-white p-4 rounded-2xl border border-slate-200/80 text-center shadow-sm transition duration-300 hover:shadow-xl hover:-translate-y-1">
                    <img src="<?= $foto ?>" alt="<?= htmlspecialchars($g['nama']) ?>" class="w-full h-44 object-cover rounded-xl mb-3">
                    <h3 class="font-bold text-slate-900 text-sm truncate"><?= htmlspecialchars($g['nama']) ?></h3>
                    <p class="text-xs text-blue-800 font-semibold mt-1"><?= htmlspecialchars($g['jabatan']) ?></p>
                </div>
            <?php 
                }
            } else {
                echo "<p class='text-slate-500 text-sm col-span-full text-center py-8'>Belum ada data guru & staff.</p>";
            }
            ?>
        </div>
    </main>

    <footer class="bg-slate-900 text-slate-500 text-xs py-6 border-t border-slate-800 text-center">
        <p>&copy; <?= date('Y') ?> SMKS PGRI Bandung. All Rights Reserved.</p>
    </footer>

</body>
</html>