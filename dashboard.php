<?php
include 'koneksi.php';

// Proteksi Session Login Admin
if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header("Location: login.php");
    exit;
}

$pesan = '';
$edit_berita = null;
$edit_guru   = null;

// Fungsi Upload Gambar Aman (Validasi Ukuran, Ekstensi & MIME Type Fisik)
function upload_gambar_aman($file_input_name, $existing_path = '') {
    if (!isset($_FILES[$file_input_name]) || $_FILES[$file_input_name]['error'] !== UPLOAD_ERR_OK) {
        return ['status' => true, 'path' => $existing_path];
    }

    $file = $_FILES[$file_input_name];
    $max_size = 3 * 1024 * 1024; // Limit Maksimal 3MB

    if ($file['size'] > $max_size) {
        return ['status' => false, 'error' => 'Ukuran file maksimal 3MB!'];
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($ext, $allowed_ext)) {
        return ['status' => false, 'error' => 'Format file harus JPG, JPEG, PNG, atau WEBP!'];
    }

    // Pengecekan MIME Type Fisik File
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowed_mime = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($mime, $allowed_mime)) {
        return ['status' => false, 'error' => 'File yang diunggah bukan gambar valid!'];
    }

    // Rename Acak Unik (Mencegah Eksekusi PHP Backdoor)
    $new_filename = time() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
    $target_dir   = 'img/';
    
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    $target_path = $target_dir . $new_filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        return ['status' => true, 'path' => $target_path];
    }

    return ['status' => false, 'error' => 'Gagal mengunggah file ke server.'];
}

// 1. LOGIKA UPDATE STATISTIK (Disesuaikan dengan index: Guru, Total Siswa, Rombel, Ruang Kelas)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_statistik'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $guru        = (int)($_POST['guru'] ?? 0);
    $siswa_laki  = (int)($_POST['siswa_laki'] ?? 0); // Total siswa disimpan ke siswa_laki agar query di index tetap berjalan aman
    $rombel      = (int)($_POST['rombel'] ?? 0);
    $ruang_kelas = (int)($_POST['ruang_kelas'] ?? 0);

    $stmt = mysqli_prepare($koneksi, "INSERT INTO statistik (id, guru, siswa_laki, rombel, ruang_kelas) 
             VALUES (1, ?, ?, ?, ?) 
             ON DUPLICATE KEY UPDATE guru=?, siswa_laki=?, rombel=?, ruang_kelas=?");
    
    mysqli_stmt_bind_param($stmt, "iiiiiiii", $guru, $siswa_laki, $rombel, $ruang_kelas, $guru, $siswa_laki, $rombel, $ruang_kelas);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: dashboard.php?status=stat_sukses");
    exit;
}

// 2. LOGIKA KELOLA BERITA (CRUD Prepared Statement)
if (isset($_GET['hapus_berita'])) {
    verify_csrf_token($_GET['csrf_token'] ?? '');
    $id_hapus = (int)$_GET['hapus_berita'];

    $stmt = mysqli_prepare($koneksi, "DELETE FROM berita WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_hapus);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: dashboard.php?status=hapus_berita_sukses");
    exit;
}

if (isset($_GET['edit_berita'])) {
    $id_edit = (int)$_GET['edit_berita'];
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM berita WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_edit);
    mysqli_stmt_execute($stmt);
    $edit_berita = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan_berita'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $judul     = trim($_POST['judul'] ?? '');
    $isi       = trim($_POST['isi'] ?? '');
    $id_berita = (int)($_POST['id_berita'] ?? 0);

    $upload = upload_gambar_aman('gambar', $edit_berita['gambar'] ?? '');

    if (!$upload['status']) {
        $pesan = $upload['error'];
    } else {
        $path_gambar = str_replace('img/', '', $upload['path']);

        if ($id_berita > 0) {
            $stmt = mysqli_prepare($koneksi, "UPDATE berita SET judul = ?, isi = ?, gambar = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "sssi", $judul, $isi, $path_gambar, $id_berita);
        } else {
            $stmt = mysqli_prepare($koneksi, "INSERT INTO berita (judul, isi, gambar) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $judul, $isi, $path_gambar);
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: dashboard.php?status=berita_sukses");
        exit;
    }
}

// 3. LOGIKA KELOLA GURU (CRUD Prepared Statement)
if (isset($_GET['hapus_guru'])) {
    verify_csrf_token($_GET['csrf_token'] ?? '');
    $id_hapus = (int)$_GET['hapus_guru'];

    $stmt = mysqli_prepare($koneksi, "DELETE FROM guru WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_hapus);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: dashboard.php?status=hapus_guru_sukses");
    exit;
}

if (isset($_GET['edit_guru'])) {
    $id_edit = (int)$_GET['edit_guru'];
    $stmt = mysqli_prepare($koneksi, "SELECT * FROM guru WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id_edit);
    mysqli_stmt_execute($stmt);
    $edit_guru = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    mysqli_stmt_close($stmt);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan_guru'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $nama    = trim($_POST['nama'] ?? '');
    $jabatan = trim($_POST['jabatan'] ?? '');
    $id_guru = (int)($_POST['id_guru'] ?? 0);

    $upload = upload_gambar_aman('foto', $edit_guru['foto'] ?? 'img/default.jpg');

    if (!$upload['status']) {
        $pesan = $upload['error'];
    } else {
        $path_foto = $upload['path'];

        if ($id_guru > 0) {
            $stmt = mysqli_prepare($koneksi, "UPDATE guru SET nama = ?, jabatan = ?, foto = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "sssi", $nama, $jabatan, $path_foto, $id_guru);
        } else {
            $stmt = mysqli_prepare($koneksi, "INSERT INTO guru (nama, jabatan, foto) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sss", $nama, $jabatan, $path_foto);
        }

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        header("Location: dashboard.php?status=guru_sukses");
        exit;
    }
}

// Ambil Statistik Terkini
$q_stat = mysqli_query($koneksi, "SELECT * FROM statistik WHERE id=1");
$stat_curr = mysqli_fetch_assoc($q_stat);
$csrf_token = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SMKS PGRI Bandung</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Header Top Info (Sesuaikan dengan index.php) -->
    <div class="bg-blue-900 text-white text-xs py-2 px-4 border-b border-blue-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span><i class="fa-solid fa-graduation-cap text-yellow-400 mr-1"></i> Yayasan Pembina Lembaga Pendidikan PGRI</span>
                <span class="hidden md:inline"><i class="fa-solid fa-location-dot text-yellow-400 mr-1"></i> Kota Bandung</span>
            </div>
            <div class="font-semibold text-yellow-300">
                <i class="fa-solid fa-user-shield animate-pulse mr-1"></i> Panel Pengelola Sistem
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar Admin -->
    <nav class="bg-white sticky top-0 z-50 shadow-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <a href="dashboard.php" class="flex items-center gap-3">
                <img src="img/logo.png" alt="Logo PGRI" class="w-12 h-12 object-contain shrink-0">
                <div>
                    <h1 class="text-xl font-extrabold text-blue-950 leading-none">SMKS PGRI <span class="text-red-600">ADMIN</span></h1>
                    <span class="text-xs font-bold text-yellow-500 tracking-wider">MANAGEMENT SYSTEM</span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="index.php" target="_blank" class="bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-200 px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-globe text-blue-900"></i> Lihat Website
                </a>
                <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-md shadow-red-600/30">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Content Area Utama -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-grow space-y-6">

        <!-- Banner Hero Dashboard (Senada dengan Banner Utama Index) -->
        <div class="relative bg-gradient-to-br from-blue-950 via-blue-900 to-slate-900 text-white p-6 sm:p-8 rounded-3xl shadow-lg border border-white/10 overflow-hidden">
            <div class="relative z-10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <span class="inline-block bg-yellow-500 text-slate-950 font-extrabold text-[10px] px-3 py-1 rounded-full uppercase tracking-wider mb-2">
                        Control Panel Administrator
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black text-white leading-tight">
                        Selamat Datang, Admin <span class="text-yellow-400">SMKS PGRI</span>
                    </h1>
                    <p class="text-blue-100 text-xs sm:text-sm mt-1 max-w-xl leading-relaxed">
                        Kelola seluruh informasi sekolah secara terpusat, mulai dari statistik data kemendikbud, berita kegiatan, hingga data guru dan staff.
                    </p>
                </div>
                <div class="bg-white/10 border border-white/20 px-4 py-2.5 rounded-2xl backdrop-blur-md text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-lock text-emerald-400 text-sm"></i>
                    <div>
                        <span class="block text-[10px] text-blue-200 uppercase leading-none">Keamanan</span>
                        <span class="text-white">Session Protected</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifikasi Aksi -->
        <?php if (isset($_GET['status'])): ?>
            <div class="bg-emerald-100 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i> Operasi data berhasil diproses dan tersimpan dengan aman!
            </div>
        <?php endif; ?>

        <?php if (!empty($pesan)): ?>
            <div class="bg-red-100 border border-red-200 text-red-800 p-4 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-red-600 text-base"></i> <?= e($pesan) ?>
            </div>
        <?php endif; ?>

        <!-- GRID UTAMA PANEL ADMIN -->
        <div class="grid lg:grid-cols-3 gap-6">

            <!-- KOLOM KIRI: Form Update Statistik, Form Guru, & Form Berita -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- 1. Form Update Statistik Sekolah (SESUAI DENGAN INDEX) -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="border-b border-slate-100 pb-3 mb-4 flex items-center justify-between">
                        <h2 class="text-sm font-extrabold text-blue-950 flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-yellow-500"></i> Update Statistik Sekolah
                        </h2>
                        <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded-full">Dinamis</span>
                    </div>

                    <form method="POST" class="space-y-3 text-xs">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Guru & Staff</label>
                            <input type="number" name="guru" value="<?= e($stat_curr['guru'] ?? 1) ?>" required class="w-full p-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Total Siswa</label>
                            <input type="number" name="siswa_laki" value="<?= e(($stat_curr['siswa_laki'] ?? 0) + ($stat_curr['siswa_perempuan'] ?? 0) ?: 233) ?>" required class="w-full p-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Rombongan Belajar</label>
                            <input type="number" name="rombel" value="<?= e($stat_curr['rombel'] ?? 12) ?>" required class="w-full p-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Ruang Kelas</label>
                            <input type="number" name="ruang_kelas" value="<?= e($stat_curr['ruang_kelas'] ?? 9) ?>" required class="w-full p-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900">
                        </div>
                        <div class="pt-2">
                            <button type="submit" name="update_statistik" class="w-full bg-blue-900 hover:bg-blue-950 text-white font-bold py-2.5 rounded-xl transition shadow-md text-xs">
                                Simpan Perubahan Statistik
                            </button>
                        </div>
                    </form>
                </div>

                <!-- 2. Form Tambah / Edit Guru & Staff -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="border-b border-slate-100 pb-3 mb-4">
                        <h2 class="text-sm font-extrabold text-blue-950 flex items-center gap-2">
                            <i class="fa-solid fa-user-tie text-emerald-600"></i>
                            <?= $edit_guru ? 'Edit Guru & Staff' : 'Tambah Guru & Staff' ?>
                        </h2>
                    </div>
                    
                    <form method="POST" enctype="multipart/form-data" class="space-y-3 text-xs">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="id_guru" value="<?= e($edit_guru['id'] ?? '') ?>">
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama" value="<?= e($edit_guru['nama'] ?? '') ?>" placeholder="Contoh: Yeni Anisah, S.Pd., MM." required class="w-full p-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Jabatan / Pengajar</label>
                            <input type="text" name="jabatan" value="<?= e($edit_guru['jabatan'] ?? '') ?>" placeholder="Contoh: Kepala Sekolah / Guru DKV" required class="w-full p-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Upload Foto Profil</label>
                            <input type="file" name="foto" accept="image/*" class="w-full p-2 border border-slate-200 rounded-xl text-slate-500 bg-slate-50">
                        </div>
                        <button type="submit" name="simpan_guru" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-xl transition shadow-md">
                            <?= $edit_guru ? 'Update Data Guru' : 'Simpan Data Guru' ?>
                        </button>
                        <?php if($edit_guru): ?>
                            <a href="dashboard.php" class="block text-center text-slate-500 mt-2 hover:underline">Batal Edit</a>
                        <?php endif; ?>
                    </form>
                </div>

                <!-- 3. Form Tambah / Edit Berita -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                    <div class="border-b border-slate-100 pb-3 mb-4">
                        <h2 class="text-sm font-extrabold text-blue-950 flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square text-red-600"></i>
                            <?= $edit_berita ? 'Edit Berita' : 'Tambah Berita' ?>
                        </h2>
                    </div>
                    
                    <form method="POST" enctype="multipart/form-data" class="space-y-3 text-xs">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="id_berita" value="<?= e($edit_berita['id'] ?? '') ?>">
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Judul Berita</label>
                            <input type="text" name="judul" value="<?= e($edit_berita['judul'] ?? '') ?>" required class="w-full p-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Upload Gambar</label>
                            <input type="file" name="gambar" accept="image/*" class="w-full p-2 border border-slate-200 rounded-xl text-slate-500 bg-slate-50">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Isi Berita</label>
                            <textarea name="isi" rows="4" required class="w-full p-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-900"><?= e($edit_berita['isi'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" name="simpan_berita" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl transition shadow-md">
                            <?= $edit_berita ? 'Update Berita' : 'Simpan Berita' ?>
                        </button>
                        <?php if($edit_berita): ?>
                            <a href="dashboard.php" class="block text-center text-slate-500 mt-2 hover:underline">Batal Edit</a>
                        <?php endif; ?>
                    </form>
                </div>

            </div>

            <!-- KOLOM KANAN: Tabel Data Guru, Berita, & Pesan Masuk -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- 1. Tabel Kelola Data Guru & Staff -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                    <h2 class="text-sm font-extrabold text-blue-950 mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-users text-emerald-600"></i> Data Guru & Staff Pengajar
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[10px]">
                                    <th class="p-3">Foto</th>
                                    <th class="p-3">Nama</th>
                                    <th class="p-3">Jabatan</th>
                                    <th class="p-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php
                                $q_guru_list = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY id DESC");
                                if (mysqli_num_rows($q_guru_list) > 0) {
                                    while ($g = mysqli_fetch_assoc($q_guru_list)) {
                                ?>
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="p-3">
                                            <img src="<?= e(file_exists($g['foto']) ? $g['foto'] : 'img/default.jpg') ?>" alt="<?= e($g['nama']) ?>" class="w-10 h-10 object-cover rounded-full border border-slate-200">
                                        </td>
                                        <td class="p-3 font-bold text-slate-800"><?= e($g['nama']) ?></td>
                                        <td class="p-3 text-blue-900 font-semibold"><?= e($g['jabatan']) ?></td>
                                        <td class="p-3 text-center space-x-2 whitespace-nowrap">
                                            <a href="dashboard.php?edit_guru=<?= $g['id'] ?>" class="bg-amber-500 hover:bg-amber-600 text-white px-2.5 py-1.5 rounded-lg text-[10px] font-bold inline-flex items-center gap-1 shadow-sm">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </a>
                                            <a href="dashboard.php?hapus_guru=<?= $g['id'] ?>&csrf_token=<?= $csrf_token ?>" onclick="return confirm('Yakin ingin menghapus data guru ini?')" class="bg-red-600 hover:bg-red-700 text-white px-2.5 py-1.5 rounded-lg text-[10px] font-bold inline-flex items-center gap-1 shadow-sm">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='p-4 text-slate-400 text-center'>Belum ada data guru.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2. Tabel Kelola Berita -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                    <h2 class="text-sm font-extrabold text-blue-950 mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-newspaper text-blue-900"></i> Daftar Berita Diterbitkan
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[10px]">
                                    <th class="p-3">Tanggal</th>
                                    <th class="p-3">Judul</th>
                                    <th class="p-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php
                                $q_berita = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC");
                                if (mysqli_num_rows($q_berita) > 0) {
                                    while ($b = mysqli_fetch_assoc($q_berita)) {
                                ?>
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="p-3 text-slate-500 whitespace-nowrap"><?= date('d M Y', strtotime($b['created_at'])) ?></td>
                                        <td class="p-3 font-semibold text-slate-800"><?= e($b['judul']) ?></td>
                                        <td class="p-3 text-center space-x-2 whitespace-nowrap">
                                            <a href="dashboard.php?edit_berita=<?= $b['id'] ?>" class="bg-amber-500 hover:bg-amber-600 text-white px-2.5 py-1.5 rounded-lg text-[10px] font-bold inline-flex items-center gap-1 shadow-sm">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </a>
                                            <a href="dashboard.php?hapus_berita=<?= $b['id'] ?>&csrf_token=<?= $csrf_token ?>" onclick="return confirm('Yakin ingin menghapus berita ini?')" class="bg-red-600 hover:bg-red-700 text-white px-2.5 py-1.5 rounded-lg text-[10px] font-bold inline-flex items-center gap-1 shadow-sm">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='p-4 text-slate-400 text-center'>Belum ada berita.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 3. Tabel Pesan Masuk Pengunjung -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
                    <h2 class="text-sm font-extrabold text-blue-950 mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
                        <i class="fa-solid fa-envelope text-blue-900"></i> Pesan Masuk Pengunjung
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[10px]">
                                    <th class="p-3">Nama / Email</th>
                                    <th class="p-3">Subjek</th>
                                    <th class="p-3">Pesan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php
                                $q_kontak = mysqli_query($koneksi, "SELECT * FROM kontak ORDER BY id DESC LIMIT 5");
                                if (mysqli_num_rows($q_kontak) > 0) {
                                    while ($k = mysqli_fetch_assoc($q_kontak)) {
                                ?>
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="p-3 font-bold text-slate-800">
                                            <?= e($k['nama']) ?><br>
                                            <span class="text-[10px] text-blue-600 font-normal"><?= e($k['email']) ?></span>
                                        </td>
                                        <td class="p-3 text-slate-700 font-semibold"><?= e($k['subjek']) ?></td>
                                        <td class="p-3 text-slate-600"><?= e($k['pesan']) ?></td>
                                    </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='p-4 text-slate-400 text-center'>Belum ada pesan masuk.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <!-- Footer Diselaraskan -->
    <footer class="bg-slate-900 text-slate-500 text-xs py-6 border-t border-slate-800 text-center">
        <p>&copy; <?= date('Y') ?> SMKS PGRI Bandung Management System. All Rights Reserved.</p>
    </footer>

</body>
</html>
