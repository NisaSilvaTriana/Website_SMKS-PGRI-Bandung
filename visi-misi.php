<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi & Misi - SMKS PGRI Bandung</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
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
        .delay-200 { animation-delay: 0.3s; }
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

    <!-- Header Banner -->
    <section class="bg-gradient-to-r from-blue-950 via-blue-900 to-slate-900 text-white py-16 px-4 mb-10 animate-fade-up">
        <div class="max-w-7xl mx-auto text-center">
            <span class="text-yellow-400 text-xs font-extrabold uppercase tracking-widest">Portal Informasi Resmi</span>
            <h1 class="text-3xl sm:text-4xl font-black mt-2">Visi & Misi SMKS PGRI Bandung</h1>
        </div>
    </section>

    <!-- Isi Visi Misi -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="space-y-8">
            <!-- Box Visi -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200/80 shadow-sm animate-fade-up delay-100 transition duration-300 hover:shadow-xl">
                <span class="inline-block bg-blue-50 text-blue-900 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase mb-3">Visi Sekolah</span>
                <p class="text-slate-800 text-base sm:text-lg font-bold italic leading-relaxed uppercase">
                    "MENGHASILKAN LULUSAN YANG BERAKHLAK MULIA, SEHAT JASMANI ROHANI, KREATIF, TERAMPIL, MANDIRI, BERWAWASAN LINGKUNGAN, KOMPETEN DIBIDANGNYA DAN MEMILIKI KEUNGGULAN BERSAING DI DUNIA KERJA, DUNIA USAHA SERTA DAPAT MELANJUTKAN KE JENJANG YANG LEBIH TINGGI PADA TAHUN 2024."
                </p>
            </div>

            <!-- Box Misi -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200/80 shadow-sm animate-fade-up delay-200 transition duration-300 hover:shadow-xl">
                <span class="inline-block bg-red-50 text-red-700 text-[10px] font-extrabold px-3 py-1 rounded-full uppercase mb-4">Misi Sekolah</span>
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

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-500 text-xs py-6 border-t border-slate-800 text-center">
        <p>&copy; <?= date('Y') ?> SMKS PGRI Bandung. All Rights Reserved.</p>
    </footer>

</body>
</html>