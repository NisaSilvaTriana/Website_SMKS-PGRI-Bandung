<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Visi & Misi - SMKS PGRI Bandung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800">

    <!-- Header Navigation Ringkas -->
    <nav class="bg-white sticky top-0 z-50 shadow-md border-b border-slate-100 py-3">
        <div class="max-w-7xl mx-auto px-4 flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-3">
                <img src="img/logo.png" alt="Logo PGRI" class="w-10 h-10 object-contain">
                <span class="font-extrabold text-blue-950">SMKS PGRI BANDUNG</span>
            </a>
            <a href="index.php" class="text-xs font-bold text-blue-900 hover:underline">&larr; Kembali ke Beranda</a>
        </div>
    </nav>

    <!-- Isi Visi Misi -->
    <main class="max-w-5xl mx-auto px-4 py-16">
        <h1 class="text-3xl font-extrabold text-blue-950 mb-8 text-center">Visi & Misi Sekolah</h1>
        
        <div class="space-y-8">
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                <span class="inline-block bg-blue-100 text-blue-900 text-xs font-bold px-3 py-1 rounded-full uppercase mb-3">Visi Sekolah</span>
                <p class="text-slate-800 text-base sm:text-lg font-bold italic leading-relaxed uppercase">
                    "MENGHASILKAN LULUSAN YANG BERAKHLAK MULIA, SEHAT JASMANI ROHANI, KREATIF, TERAMPIL, MANDIRI, BERWAWASAN LINGKUNGAN, KOMPETEN DIBIDANGNYA DAN MEMILIKI KEUNGGULAN BERSAING DI DUNIA KERJA, DUNIA USAHA SERTA DAPAT MELANJUTKAN KE JENJANG YANG LEBIH TINGGI PADA TAHUN 2024."
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                <span class="inline-block bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full uppercase mb-4">Misi Sekolah</span>
                <ol class="space-y-3 text-slate-700 text-sm leading-relaxed list-decimal list-inside font-medium">
                    <li class="pl-2">Mengembangkan potensi peserta didik sebagai sumber daya manusia yang berkualitas melalui dukungan iman dan taqwa, ilmu pengetahuan, teknologi dan seni budaya serta sehat jasmani dan rohani.</li>
                    <li class="pl-2">Membina peserta didik agar memiliki tingkat kecerdasan intelektual, emosional dan spiritual yang tinggi serta memupuk rasa cinta terhadap tanah air.</li>
                    <li class="pl-2">Membina dan mengembangkan peserta didik agar memiliki karakter pribadi yang baik, disiplin, serta kreativitas yang tinggi.</li>
                    <li class="pl-2">Membina dan meningkatkan kualitas pembelajaran teori dan praktik.</li>
                    <li class="pl-2">Meningkatkan mutu sumber daya pendidik dan tenaga kependidikan.</li>
                    <li class="pl-2">Mewujudkan sekolah yang unggul dan menjadi kebanggaan masyarakat.</li>
                    <li class="pl-2">Memberikan layanan prima terhadap pelanggan dengan ditunjang oleh sumber daya Pendidikan dan tenaga kependidikan yang memadai.</li>
                    <li class="pl-2">Mewujudkan partisipasi aktif seluruh warga sekolah dalam pelaksanaan peningkatan mutu Pendidikan dalam iklim sekolah yang kondusif dan berwawasan lingkungan.</li>
                    <li class="pl-2">Melengkapi sarana dan prasarana yang sesuai dengan standar kebutuhan pembelajaran.</li>
                </ol>
            </div>
        </div>
    </main>

</body>
</html>