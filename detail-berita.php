<?php 
include 'koneksi.php'; 

if (!isset($_GET['id'])) {
    header("Location: berita.php");
    exit;
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$query = mysqli_query($koneksi, "SELECT * FROM berita WHERE id = '$id'");

// Jika ID tidak ditemukan di database
if (mysqli_num_rows($query) === 0) {
    header("Location: berita.php");
    exit;
}

$b = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($b['judul']) ?> - SMKS PGRI Bandung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <nav class="bg-white sticky top-0 z-50 shadow-md border-b border-slate-100 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-3">
                <img src="img/logo.png" alt="Logo PGRI" class="w-10 h-10 object-contain shrink-0">
                <div>
                    <h1 class="text-lg font-extrabold text-blue-950 leading-none">SMKS PGRI</h1>
                    <span class="text-[10px] font-bold text-red-600 tracking-wider">BANDUNG</span>
                </div>
            </a>
            <a href="berita.php" class="text-xs font-bold text-blue-900 hover:text-red-600 transition flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Berita
            </a>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        <article class="bg-white p-8 sm:p-10 rounded-2xl border border-slate-200 shadow-sm">
            <!-- Meta Tag Berita -->
            <div class="flex items-center gap-3 mb-4">
                <span class="bg-blue-50 text-blue-900 text-xs font-extrabold px-3 py-1 rounded-full uppercase">Informasi Resmi</span>
                <span class="text-xs text-slate-400 font-semibold flex items-center gap-1">
                    <i class="fa-regular fa-clock text-red-500"></i>
                    Diterbitkan: <?= date('d M Y', strtotime($b['created_at'])) ?>
                </span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-6 leading-snug">
                <?= htmlspecialchars($b['judul']) ?>
            </h1>

            <?php if (!empty($b['gambar']) && file_exists('img/' . $b['gambar'])): ?>
                <div class="w-full overflow-hidden rounded-xl mb-6 shadow-sm">
                    <img src="img/<?= $b['gambar'] ?>" alt="<?= htmlspecialchars($b['judul']) ?>" class="w-full max-h-96 object-cover">
                </div>
            <?php endif; ?>

            <hr class="border-slate-100 mb-6">

            <div class="text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
                <?= nl2br(htmlspecialchars($b['isi'])) ?>
            </div>
        </article>
    </main>

    <footer class="bg-slate-900 text-slate-500 text-xs py-6 border-t border-slate-800 text-center">
        <p>&copy; <?= date('Y') ?> SMKS PGRI Bandung. All Rights Reserved.</p>
    </footer>

</body>
</html>