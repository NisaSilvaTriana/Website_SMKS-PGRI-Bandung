<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ekstrakurikuler - SMKS PGRI Bandung</title>
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
        <h1 class="text-3xl font-extrabold text-blue-950 mb-8">Ekstrakurikuler Sekolah</h1>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $query_eskul = mysqli_query($koneksi, "SELECT * FROM ekskul");
            while ($e = mysqli_fetch_assoc($query_eskul)) {
            ?>
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-start gap-4">
                    <div class="w-10 h-10 bg-blue-900 text-yellow-400 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-trophy text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-base mb-1"><?= $e['nama_ekskul'] ?></h3>
                        <p class="text-slate-600 text-xs leading-relaxed"><?= $e['deskripsi'] ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </main>

</body>
</html>