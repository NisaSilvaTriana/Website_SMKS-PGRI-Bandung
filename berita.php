<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita & Informasi - SMKS PGRI Bandung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @keyframes ultraSmoothUp {
            0% { opacity: 0; transform: translateY(40px) scale(0.98); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
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
            <span class="text-yellow-400 text-xs font-extrabold uppercase tracking-widest">Portal Informasi Resmi</span>
            <h1 class="text-3xl sm:text-4xl font-black mt-2">Kabar & Agenda SMKS PGRI Bandung</h1>
            <p class="text-blue-200 text-sm mt-2 max-w-xl mx-auto">Dapatkan informasi terkini mengenai kegiatan sekolah, pengumuman PPDB, serta prestasi peserta didik.</p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20 animate-fade-up delay-100">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            $query_berita = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC");
            if (mysqli_num_rows($query_berita) > 0) {
                while ($b = mysqli_fetch_assoc($query_berita)) {
            ?>
                <article class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col justify-between overflow-hidden">
                    <div>
                        <?php if (!empty($b['gambar']) && file_exists('img/' . $b['gambar'])): ?>
                            <div class="w-full h-48 overflow-hidden bg-slate-100">
                                <img src="img/<?= e($b['gambar']) ?>" alt="<?= e($b['judul']) ?>" class="w-full h-full object-cover hover:scale-105 transition duration-300">
                            </div>
                        <?php endif; ?>

                        <div class="p-6">
                            <div class="flex justify-between items-center mb-3">
                                <span class="bg-blue-50 text-blue-900 text-[10px] font-extrabold px-2.5 py-1 rounded-full uppercase">Informasi</span>
                                <span class="text-xs text-slate-400 font-semibold flex items-center gap-1">
                                    <i class="fa-regular fa-clock text-red-500"></i>
                                    <?= date('d M Y', strtotime($b['created_at'])) ?>
                                </span>
                            </div>

                            <h2 class="text-lg font-bold text-slate-900 mb-3 hover:text-red-600 transition leading-snug">
                                <?= e($b['judul']) ?>
                            </h2>

                            <p class="text-slate-600 text-xs leading-relaxed line-clamp-3">
                                <?= e($b['isi']) ?>
                            </p>
                        </div>
                    </div>

                    <div class="px-6 pb-6 pt-2 border-t border-slate-100 flex justify-between items-center">
                        <a href="detail-berita.php?id=<?= $b['id'] ?>" class="text-xs font-bold text-red-600 hover:text-red-700 flex items-center gap-1">
                            Baca Selengkapnya <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>
                </article>
            <?php 
                }
            } else {
                echo "
                <div class='col-span-3 text-center py-12 bg-white rounded-2xl border border-dashed border-slate-300'>
                    <i class='fa-regular fa-folder-open text-4xl text-slate-300 mb-3 block'></i>
                    <p class='text-slate-500 text-sm font-semibold'>Belum ada berita yang diterbitkan saat ini.</p>
                </div>";
            }
            ?>
        </div>
    </main>

    <footer class="bg-slate-900 text-slate-500 text-xs py-6 border-t border-slate-800 text-center">
        <p>&copy; <?= date('Y') ?> SMKS PGRI Bandung. All Rights Reserved.</p>
    </footer>

</body>
</html>