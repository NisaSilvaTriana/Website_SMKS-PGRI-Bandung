<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Guru & Staff - SMKS PGRI Bandung</title>
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
        <h1 class="text-3xl font-extrabold text-blue-950 mb-8">Guru & Staff Pengajar</h1>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            <?php
            $query_guru = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY id ASC");
            if (mysqli_num_rows($query_guru) > 0) {
                while ($g = mysqli_fetch_assoc($query_guru)) {
                    $foto = (!empty($g['foto']) && file_exists($g['foto'])) ? $g['foto'] : 'img/default.jpg';
            ?>
                <div class="bg-white p-4 rounded-2xl border border-slate-200 text-center shadow-sm">
                    <img src="<?= $foto ?>" alt="<?= htmlspecialchars($g['nama']) ?>" class="w-full h-44 object-cover rounded-xl mb-3">
                    <h3 class="font-bold text-slate-900 text-sm truncate"><?= htmlspecialchars($g['nama']) ?></h3>
                    <p class="text-xs text-blue-800 font-semibold mt-1"><?= htmlspecialchars($g['jabatan']) ?></p>
                </div>
            <?php 
                }
            } else {
                echo "<p class='text-slate-500 text-sm col-span-4 text-center'>Belum ada data guru & staff.</p>";
            }
            ?>
        </div>
    </main>

</body>
</html>