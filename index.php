<?php 
include 'koneksi.php'; 

// 1. Proses Simpan Pesan Kontak dari Pengunjung
$pesan_status = '';
if (isset($_POST['kirim_pesan'])) {
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email  = mysqli_real_escape_string($koneksi, $_POST['email']);
    $subjek = mysqli_real_escape_string($koneksi, $_POST['subjek']);
    $pesan  = mysqli_real_escape_string($koneksi, $_POST['pesan']);

    $insert_kontak = mysqli_query($koneksi, "INSERT INTO kontak (nama, email, subjek, pesan) VALUES ('$nama', '$email', '$subjek', '$pesan')");
    if ($insert_kontak) {
        $pesan_status = "Pesan Anda berhasil terkirim! Terima kasih.";
    }
}

// 2. Ambil Data Statistik dari Database (8 Item Kemendikbud)
$q_stat = mysqli_query($koneksi, "SELECT * FROM statistik WHERE id=1");
$stat = mysqli_fetch_assoc($q_stat);

// Ambil jumlah guru dinamis jika ada dari tabel guru
$q_guru_cnt = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM guru");
$tot_guru_db = mysqli_fetch_assoc($q_guru_cnt)['total'] ?? 0;
$jml_guru = ($tot_guru_db > 0) ? $tot_guru_db : ($stat['guru'] ?? 22);
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMKS PGRI Bandung - Official Website</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Header Top Info -->
    <div class="bg-blue-900 text-white text-xs py-2 px-4 border-b border-blue-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span><i class="fa-solid fa-graduation-cap text-yellow-400 mr-1"></i> Yayasan Pembina Lembaga Pendidikan PGRI</span>
                <span class="hidden md:inline"><i class="fa-solid fa-location-dot text-yellow-400 mr-1"></i> Kota Bandung</span>
            </div>
            <div class="font-semibold text-yellow-300">
                <i class="fa-solid fa-bullhorn animate-pulse mr-1"></i> PPDB Tahun Pelajaran Baru Telah Dibuka!
            </div>
        </div>
    </div>

    <!-- Main Navigation (Khusus Pengunjung - Tidak Ada Tombol Login) -->
    <nav class="bg-white sticky top-0 z-50 shadow-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <a href="index.php" class="flex items-center gap-3">
                <img src="img/logo.png" alt="Logo PGRI" class="w-12 h-12 object-contain shrink-0">
                <div>
                    <h1 class="text-xl font-extrabold text-blue-950 leading-none">SMKS PGRI</h1>
                    <span class="text-xs font-bold text-red-600 tracking-wider">BANDUNG</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <div class="hidden md:flex items-center space-x-8 text-sm font-bold text-slate-700">
                <a href="index.php" class="text-blue-900">Beranda</a>
                <a href="visi-misi.php" class="hover:text-blue-900 transition">Visi & Misi</a>
                <a href="jurusan.php" class="hover:text-blue-900 transition">Konsentrasi Keahlian</a>
                <a href="berita.php" class="hover:text-blue-900 transition">Berita</a>
                <a href="ekskul.php" class="hover:text-blue-900 transition">Eskul</a>
                <a href="guru.php" class="hover:text-blue-900 transition">Guru & Staff</a>
                <a href="#kontak" class="hover:text-blue-900 transition">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Hero Banner Utama -->
    <section class="relative bg-gradient-to-br from-blue-950 via-blue-900 to-slate-900 text-white py-20 lg:py-24 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block bg-yellow-500 text-slate-950 font-extrabold text-xs px-3 py-1 rounded-full uppercase tracking-wider mb-4">
                    Sekolah Cerdas, Cendekia, Berkelanjutan
                </span>
                <h1 class="text-4xl sm:text-5xl font-black leading-tight mb-6">
                    Mewujudkan Lulusan Siap Kerja, Mandiri & <span class="text-yellow-400">Berwirausaha</span>
                </h1>
                <p class="text-blue-100 text-base mb-8 leading-relaxed">
                    SMKS PGRI Bandung membekali peserta didik dengan keterampilan keahlian modern, fasilitasi praktek industri, serta pembentukan karakter disiplin dan siap bersaing.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="jurusan.php" class="bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-3 rounded-xl text-sm transition shadow-lg shadow-red-600/30">
                        Lihat Konsentrasi Keahlian &rarr;
                    </a>
                    <a href="#kontak" class="bg-white/10 hover:bg-white/20 text-white font-bold px-6 py-3 rounded-xl text-sm border border-white/20 transition">
                        Hubungi Kami
                    </a>
                </div>
            </div>

            <!-- Program Unggulan Sekolah -->
            <div class="bg-white/10 border border-white/20 p-6 sm:p-8 rounded-3xl backdrop-blur-md">
                <h3 class="text-xl font-bold text-yellow-400 mb-4 border-b border-white/10 pb-3">
                    <i class="fa-solid fa-star mr-2"></i> Program Unggulan Sekolah
                </h3>
                <ul class="space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-400 mt-1"></i>
                        <div>
                            <strong class="text-white block">Sekolah Pencetak Wirausaha (SPW)</strong>
                            <span class="text-blue-200 text-xs">Membina karakter kewirausahaan siswa agar mampu menciptakan produk dan berbisnis digital mandiri.</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-400 mt-1"></i>
                        <div>
                            <strong class="text-white block">Pengembangan Keahlian Industri & Digital</strong>
                            <span class="text-blue-200 text-xs">Pembelajaran berbasis Teaching Factory (TFA) untuk DKV, Bisnis Digital, MPLB, dan Akuntansi.</span>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-emerald-400 mt-1"></i>
                        <div>
                            <strong class="text-white block">Fasilitas Praktek & Studio Kreatif</strong>
                            <span class="text-blue-200 text-xs">Dilengkapi Lab Komputer Kejuruan, Studio Photography/Videography DKV, & Ruang Praktek Siswa (RPS).</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- SECTION STATISTIK SEKOLAH (8 Box Sesuai Tampilan Dapo Kemendikbud) -->
    <section class="py-12 bg-slate-50 border-t border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-slate-900 mb-6 tracking-tight">Statistik Sekolah</h2>

            <!-- Grid Container Utama dengan Border Luar & Pembatas Grid -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden grid grid-cols-2 md:grid-cols-4 divide-x divide-y divide-slate-200">
                
                <!-- 1. Guru -->
                <div class="p-6 flex flex-col justify-between hover:bg-slate-50/50 transition">
                    <div>
                        <i class="fa-solid fa-users text-slate-600 text-xl mb-3"></i>
                        <p class="text-xs font-semibold text-slate-500 mb-2">Guru</p>
                    </div>
                    <h3 class="text-3xl font-extrabold text-blue-600"><?= $jml_guru ?></h3>
                </div>

                <!-- 2. Siswa Laki-laki -->
                <div class="p-6 flex flex-col justify-between hover:bg-slate-50/50 transition">
                    <div>
                        <i class="fa-solid fa-mars text-slate-600 text-xl mb-3"></i>
                        <p class="text-xs font-semibold text-slate-500 mb-2">Siswa Laki-laki</p>
                    </div>
                    <h3 class="text-3xl font-extrabold text-blue-600"><?= $stat['siswa_laki'] ?? 100 ?></h3>
                </div>

                <!-- 3. Siswa Perempuan -->
                <div class="p-6 flex flex-col justify-between hover:bg-slate-50/50 transition">
                    <div>
                        <i class="fa-solid fa-venus text-slate-600 text-xl mb-3"></i>
                        <p class="text-xs font-semibold text-slate-500 mb-2">Siswa Perempuan</p>
                    </div>
                    <h3 class="text-3xl font-extrabold text-blue-600"><?= $stat['siswa_perempuan'] ?? 133 ?></h3>
                </div>

                <!-- 4. Rombongan Belajar -->
                <div class="p-6 flex flex-col justify-between hover:bg-slate-50/50 transition">
                    <div>
                        <i class="fa-solid fa-shapes text-slate-600 text-xl mb-3"></i>
                        <p class="text-xs font-semibold text-slate-500 mb-2">Rombongan...</p>
                    </div>
                    <h3 class="text-3xl font-extrabold text-blue-600"><?= $stat['rombel'] ?? 12 ?></h3>
                </div>

                <!-- 5. Daya Tampung -->
                <div class="p-6 flex flex-col justify-between hover:bg-slate-50/50 transition">
                    <div>
                        <i class="fa-solid fa-graduation-cap text-slate-600 text-xl mb-3"></i>
                        <p class="text-xs font-semibold text-slate-500 mb-2">Daya Tampung...</p>
                    </div>
                    <h3 class="text-3xl font-extrabold text-blue-600 flex items-center gap-1">
                        <?= $stat['daya_tampung'] ?? '180' ?>
                        <i class="fa-regular fa-circle-question text-blue-500 text-xs cursor-pointer" title="Daya tampung siswa baru"></i>
                    </h3>
                </div>

                <!-- 6. Ruang Kelas -->
                <div class="p-6 flex flex-col justify-between hover:bg-slate-50/50 transition">
                    <div>
                        <i class="fa-solid fa-house-chimney text-slate-600 text-xl mb-3"></i>
                        <p class="text-xs font-semibold text-slate-500 mb-2">Ruang Kelas</p>
                    </div>
                    <h3 class="text-3xl font-extrabold text-blue-600"><?= $stat['ruang_kelas'] ?? 9 ?></h3>
                </div>

                <!-- 7. Laboratorium -->
                <div class="p-6 flex flex-col justify-between hover:bg-slate-50/50 transition">
                    <div>
                        <i class="fa-solid fa-wand-magic-sparkles text-slate-600 text-xl mb-3"></i>
                        <p class="text-xs font-semibold text-slate-500 mb-2">Laboratorium</p>
                    </div>
                    <h3 class="text-3xl font-extrabold text-blue-600"><?= $stat['laboratorium'] ?? 1 ?></h3>
                </div>

                <!-- 8. Perpustakaan -->
                <div class="p-6 flex flex-col justify-between hover:bg-slate-50/50 transition">
                    <div>
                        <i class="fa-solid fa-book-bookmark text-slate-600 text-xl mb-3"></i>
                        <p class="text-xs font-semibold text-slate-500 mb-2">Perpustakaan</p>
                    </div>
                    <h3 class="text-3xl font-extrabold text-blue-600"><?= $stat['perpustakaan'] ?? 1 ?></h3>
                </div>

            </div>
        </div>
    </section>

    <!-- Ringkasan Visi Misi -->
    <section class="py-16 bg-white border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-red-600 text-xs font-bold uppercase tracking-widest">Sekilas Identitas</span>
            <h2 class="text-3xl font-extrabold text-blue-950 mt-1 mb-6">Visi SMKS PGRI Bandung</h2>
            <p class="text-slate-700 text-lg font-bold italic max-w-4xl mx-auto leading-relaxed">
                "MENGHASILKAN LULUSAN YANG BERAKHLAK MULIA, SEHAT JASMANI ROHANI, KREATIF, TERAMPIL, MANDIRI, BERWAWASAN LINGKUNGAN, KOMPETEN DIBIDANGNYA DAN MEMILIKI KEUNGGULAN BERSAING DI DUNIA KERJA..."
            </p>
            <div class="mt-8">
                <a href="visi-misi.php" class="text-blue-900 font-bold text-sm hover:underline">
                    Baca Visi & Misi Selengkapnya &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- Ringkasan Berita Terkini -->
    <section class="py-16 bg-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <span class="text-red-600 text-xs font-bold uppercase tracking-widest">Kabar Terbaru</span>
                    <h2 class="text-3xl font-extrabold text-blue-950 mt-1">Berita & Informasi</h2>
                </div>
                <a href="berita.php" class="text-sm font-bold text-blue-900 hover:underline">Lihat Semua Berita &rarr;</a>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <?php
                $query_berita = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC LIMIT 3");
                if (mysqli_num_rows($query_berita) > 0) {
                    while ($b = mysqli_fetch_assoc($query_berita)) {
                ?>
                    <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm flex flex-col justify-between">
                        <div>
                            <?php if (!empty($b['gambar']) && file_exists('img/' . $b['gambar'])): ?>
                                <img src="img/<?= $b['gambar'] ?>" alt="<?= htmlspecialchars($b['judul']) ?>" class="w-full h-44 object-cover">
                            <?php endif; ?>
                            <div class="p-6">
                                <span class="text-xs text-slate-400 font-semibold"><i class="fa-regular fa-clock mr-1"></i><?= date('d M Y', strtotime($b['created_at'])) ?></span>
                                <h3 class="text-lg font-bold text-slate-900 mt-2 mb-3 leading-snug"><?= htmlspecialchars($b['judul']) ?></h3>
                                <p class="text-slate-600 text-xs leading-relaxed line-clamp-3"><?= htmlspecialchars($b['isi']) ?></p>
                            </div>
                        </div>
                        <div class="p-6 pt-0">
                            <a href="detail-berita.php?id=<?= $b['id'] ?>" class="text-xs font-bold text-red-600 hover:underline">Baca Selengkapnya &rarr;</a>
                        </div>
                    </article>
                <?php 
                    }
                } else {
                    echo "<p class='text-slate-500 text-sm col-span-3'>Belum ada berita.</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <!-- SECTION KONTAK DAN ALAMAT -->
    <section id="kontak" class="bg-blue-950 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-10">
            <div>
                <h2 class="text-3xl font-extrabold mb-4">Hubungi SMKS PGRI Bandung</h2>
                <p class="text-blue-200 text-sm mb-6">Yayasan Pembina Lembaga Pendidikan (YPLP) PGRI Kota Bandung</p>
                <div class="space-y-4 text-xs text-slate-300">
                    <p><i class="fa-solid fa-location-dot w-6 text-yellow-400"></i> Jl. Kencanawangi Utara No.22, Cijaura, Kec. Buahbatu, Kota Bandung, Jawa Barat 40287</p>
                    <p><i class="fa-solid fa-phone w-6 text-yellow-400"></i> 0851-7123-0150</p>
                    <p><i class="fa-solid fa-envelope w-6 text-yellow-400"></i> smkspgribandung@gmail.com</p>
                </div>
            </div>
            
            <div class="bg-slate-900 p-6 rounded-2xl border border-slate-800">
                <h3 class="text-lg font-bold mb-4">Kirim Pesan Ringkas</h3>

                <?php if ($pesan_status): ?>
                    <div class="bg-emerald-500/20 text-emerald-400 p-3 rounded-xl text-xs mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i> <?= $pesan_status ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-3">
                    <input type="text" name="nama" placeholder="Nama Anda" required class="w-full bg-slate-800 text-white p-3 rounded-xl border border-slate-700 text-xs focus:outline-none focus:border-yellow-400">
                    <input type="email" name="email" placeholder="Email / Alamat Kontak" required class="w-full bg-slate-800 text-white p-3 rounded-xl border border-slate-700 text-xs focus:outline-none focus:border-yellow-400">
                    <input type="text" name="subjek" placeholder="Subjek Pesan" required class="w-full bg-slate-800 text-white p-3 rounded-xl border border-slate-700 text-xs focus:outline-none focus:border-yellow-400">
                    <textarea name="pesan" placeholder="Pesan Anda" rows="3" required class="w-full bg-slate-800 text-white p-3 rounded-xl border border-slate-700 text-xs focus:outline-none focus:border-yellow-400"></textarea>
                    <button type="submit" name="kirim_pesan" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl font-bold text-xs transition">Kirim Pesan</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-500 text-xs py-6 border-t border-slate-800 text-center">
        <p>&copy; <?= date('Y') ?> SMKS PGRI Bandung. All Rights Reserved.</p>
    </footer>

</body>
</html>