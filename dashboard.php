<?php
include 'koneksi.php';

if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header("Location: login.php");
    exit;
}

$pesan = '';
$edit_berita = null;
$edit_guru   = null;

// Validasi Upload Gambar Ketat (Anti Web Shell / Malicious Upload)
function upload_gambar_aman($file_input_name, $existing_path = '') {
    if (!isset($_FILES[$file_input_name]) || $_FILES[$file_input_name]['error'] !== UPLOAD_ERR_OK) {
        return ['status' => true, 'path' => $existing_path];
    }

    $file = $_FILES[$file_input_name];
    $max_size = 3 * 1024 * 1024; // Limit 3MB

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

    // Rename Acak Unik (Mencegah PHP Execution)
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

// 1. UPDATE STATISTIK (Prepared Statement)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_statistik'])) {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $guru            = (int)($_POST['guru'] ?? 0);
    $siswa_laki      = (int)($_POST['siswa_laki'] ?? 0);
    $siswa_perempuan = (int)($_POST['siswa_perempuan'] ?? 0);
    $rombel          = (int)($_POST['rombel'] ?? 0);
    $daya_tampung    = trim($_POST['daya_tampung'] ?? '180');
    $ruang_kelas     = (int)($_POST['ruang_kelas'] ?? 0);
    $laboratorium    = (int)($_POST['laboratorium'] ?? 0);
    $perpustakaan    = (int)($_POST['perpustakaan'] ?? 0);

    $stmt = mysqli_prepare($koneksi, "INSERT INTO statistik (id, guru, siswa_laki, siswa_perempuan, rombel, daya_tampung, ruang_kelas, laboratorium, perpustakaan) 
             VALUES (1, ?, ?, ?, ?, ?, ?, ?, ?) 
             ON DUPLICATE KEY UPDATE guru=?, siswa_laki=?, siswa_perempuan=?, rombel=?, daya_tampung=?, ruang_kelas=?, laboratorium=?, perpustakaan=?");
    
    mysqli_stmt_bind_param($stmt, "iiiisiiiiiiisiii", $guru, $siswa_laki, $siswa_perempuan, $rombel, $daya_tampung, $ruang_kelas, $laboratorium, $perpustakaan, $guru, $siswa_laki, $siswa_perempuan, $rombel, $daya_tampung, $ruang_kelas, $laboratorium, $perpustakaan);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("Location: dashboard.php?status=stat_sukses");
    exit;
}

// 2. KELOLA BERITA (CRUD Prepared Statement)
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

// 3. KELOLA GURU (CRUD Prepared Statement)
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 p-6">
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-blue-900">Dashboard Panel Admin</h1>
                <p class="text-slate-500 text-xs">SMKS PGRI Bandung Management System</p>
            </div>
            <div class="flex gap-3">
                <a href="index.php" target="_blank" class="bg-slate-100 text-slate-700 px-4 py-2 rounded-xl text-xs font-bold hover:bg-slate-200 transition flex items-center gap-1">
                    <i class="fa-solid fa-globe"></i> Lihat Website
                </a>
                <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-700 transition flex items-center gap-1">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </div>

        <?php if (isset($_GET['status'])): ?>
            <div class="bg-emerald-100 text-emerald-800 p-4 rounded-xl text-xs font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-sm"></i> Operasi data berhasil diproses!
            </div>
        <?php endif; ?>

        <?php if (!empty($pesan)): ?>
            <div class="bg-red-100 text-red-800 p-4 rounded-xl text-xs font-bold flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-sm"></i> <?= e($pesan) ?>
            </div>
        <?php endif; ?>

        <div class="grid lg:grid-cols-3 gap-6">

            <div class="lg:col-span-1 space-y-6">
                <!-- Form Update Statistik -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-sm font-bold text-blue-950 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-yellow-500"></i> Update Statistik Sekolah
                    </h2>
                    <form method="POST" class="grid grid-cols-2 gap-3 text-xs">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Jumlah Guru</label>
                            <input type="number" name="guru" value="<?= e($stat_curr['guru'] ?? 22) ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Siswa Laki-Laki</label>
                            <input type="number" name="siswa_laki" value="<?= e($stat_curr['siswa_laki'] ?? 100) ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Siswa Perempuan</label>
                            <input type="number" name="siswa_perempuan" value="<?= e($stat_curr['siswa_perempuan'] ?? 133) ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Rombel</label>
                            <input type="number" name="rombel" value="<?= e($stat_curr['rombel'] ?? 12) ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Daya Tampung</label>
                            <input type="text" name="daya_tampung" value="<?= e($stat_curr['daya_tampung'] ?? '180') ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Ruang Kelas</label>
                            <input type="number" name="ruang_kelas" value="<?= e($stat_curr['ruang_kelas'] ?? 9) ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Laboratorium</label>
                            <input type="number" name="laboratorium" value="<?= e($stat_curr['laboratorium'] ?? 1) ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Perpustakaan</label>
                            <input type="number" name="perpustakaan" value="<?= e($stat_curr['perpustakaan'] ?? 1) ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="col-span-2 mt-2">
                            <button type="submit" name="update_statistik" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-2.5 rounded-lg transition shadow-sm">
                                Simpan Perubahan Statistik
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Form Guru -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-sm font-bold text-blue-950 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-user-tie text-emerald-600"></i>
                        <?= $edit_guru ? 'Edit Guru & Staff' : 'Tambah Guru & Staff' ?>
                    </h2>
                    
                    <form method="POST" enctype="multipart/form-data" class="space-y-3 text-xs">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="id_guru" value="<?= e($edit_guru['id'] ?? '') ?>">
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama" value="<?= e($edit_guru['nama'] ?? '') ?>" required class="w-full p-2.5 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Jabatan / Pengajar</label>
                            <input type="text" name="jabatan" value="<?= e($edit_guru['jabatan'] ?? '') ?>" required class="w-full p-2.5 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Upload Foto Profil</label>
                            <input type="file" name="foto" accept="image/*" class="w-full p-2 border rounded-lg text-slate-500">
                        </div>
                        <button type="submit" name="simpan_guru" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-lg transition shadow-sm">
                            <?= $edit_guru ? 'Update Data Guru' : 'Simpan Data Guru' ?>
                        </button>
                    </form>
                </div>

                <!-- Form Berita -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-sm font-bold text-blue-950 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-red-600"></i>
                        <?= $edit_berita ? 'Edit Berita' : 'Tambah Berita' ?>
                    </h2>
                    
                    <form method="POST" enctype="multipart/form-data" class="space-y-3 text-xs">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <input type="hidden" name="id_berita" value="<?= e($edit_berita['id'] ?? '') ?>">
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Judul Berita</label>
                            <input type="text" name="judul" value="<?= e($edit_berita['judul'] ?? '') ?>" required class="w-full p-2.5 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Upload Gambar</label>
                            <input type="file" name="gambar" accept="image/*" class="w-full p-2 border rounded-lg text-slate-500">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Isi Berita</label>
                            <textarea name="isi" rows="4" required class="w-full p-2.5 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500"><?= e($edit_berita['isi'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" name="simpan_berita" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-lg transition shadow-sm">
                            <?= $edit_berita ? 'Update Berita' : 'Simpan Berita' ?>
                        </button>
                    </form>
                </div>

            </div>

            <div class="lg:col-span-2 space-y-6">
                <!-- Tabel Guru -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-sm font-bold text-blue-950 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-users text-emerald-600"></i> Data Guru & Staff
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b text-slate-600">
                                    <th class="p-3">Foto</th>
                                    <th class="p-3">Nama</th>
                                    <th class="p-3">Jabatan</th>
                                    <th class="p-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <?php
                                $q_guru_list = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY id DESC");
                                while ($g = mysqli_fetch_assoc($q_guru_list)) {
                                ?>
                                    <tr>
                                        <td class="p-3"><img src="<?= e(file_exists($g['foto']) ? $g['foto'] : 'img/default.jpg') ?>" class="w-10 h-10 object-cover rounded-full"></td>
                                        <td class="p-3 font-bold text-slate-800"><?= e($g['nama']) ?></td>
                                        <td class="p-3 text-blue-900 font-semibold"><?= e($g['jabatan']) ?></td>
                                        <td class="p-3 text-center space-x-2 whitespace-nowrap">
                                            <a href="dashboard.php?edit_guru=<?= $g['id'] ?>" class="bg-amber-500 text-white px-2 py-1 rounded text-[10px] font-bold">Edit</a>
                                            <a href="dashboard.php?hapus_guru=<?= $g['id'] ?>&csrf_token=<?= $csrf_token ?>" onclick="return confirm('Hapus data?')" class="bg-red-600 text-white px-2 py-1 rounded text-[10px] font-bold">Hapus</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tabel Berita -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-sm font-bold text-blue-950 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-newspaper text-blue-900"></i> Daftar Berita
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b text-slate-600">
                                    <th class="p-3">Tanggal</th>
                                    <th class="p-3">Judul</th>
                                    <th class="p-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <?php
                                $q_berita = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC");
                                while ($b = mysqli_fetch_assoc($q_berita)) {
                                ?>
                                    <tr>
                                        <td class="p-3 text-slate-500"><?= date('d M Y', strtotime($b['created_at'])) ?></td>
                                        <td class="p-3 font-semibold text-slate-800"><?= e($b['judul']) ?></td>
                                        <td class="p-3 text-center space-x-2 whitespace-nowrap">
                                            <a href="dashboard.php?edit_berita=<?= $b['id'] ?>" class="bg-amber-500 text-white px-2 py-1 rounded text-[10px] font-bold">Edit</a>
                                            <a href="dashboard.php?hapus_berita=<?= $b['id'] ?>&csrf_token=<?= $csrf_token ?>" onclick="return confirm('Hapus berita?')" class="bg-red-600 text-white px-2 py-1 rounded text-[10px] font-bold">Hapus</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>