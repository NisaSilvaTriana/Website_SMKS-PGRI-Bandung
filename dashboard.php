<?php
session_start();
if (!isset($_SESSION['admin_login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$pesan = '';
$edit_berita = null;
$edit_guru   = null;


// UPDATE STATISTIK SEKOLAH
if (isset($_POST['update_statistik'])) {
    $guru            = (int)$_POST['guru'];
    $siswa_laki      = (int)$_POST['siswa_laki'];
    $siswa_perempuan = (int)$_POST['siswa_perempuan'];
    $rombel          = (int)$_POST['rombel'];
    $daya_tampung    = mysqli_real_escape_string($koneksi, $_POST['daya_tampung']);
    $ruang_kelas     = (int)$_POST['ruang_kelas'];
    $laboratorium    = (int)$_POST['laboratorium'];
    $perpustakaan    = (int)$_POST['perpustakaan'];

    $query_stat = "INSERT INTO statistik (id, guru, siswa_laki, siswa_perempuan, rombel, daya_tampung, ruang_kelas, laboratorium, perpustakaan) 
                   VALUES (1, $guru, $siswa_laki, $siswa_perempuan, $rombel, '$daya_tampung', $ruang_kelas, $laboratorium, $perpustakaan) 
                   ON DUPLICATE KEY UPDATE 
                   guru=$guru, siswa_laki=$siswa_laki, siswa_perempuan=$siswa_perempuan, rombel=$rombel, 
                   daya_tampung='$daya_tampung', ruang_kelas=$ruang_kelas, laboratorium=$laboratorium, perpustakaan=$perpustakaan";
    
    mysqli_query($koneksi, $query_stat);
    header("Location: dashboard.php?status=stat_sukses");
    exit;
}


// LOGIKA KELOLA BERITA (CRUD)
if (isset($_GET['hapus_berita'])) {
    $id_hapus = mysqli_real_escape_string($koneksi, $_GET['hapus_berita']);
    mysqli_query($koneksi, "DELETE FROM berita WHERE id='$id_hapus'");
    header("Location: dashboard.php?status=hapus_berita_sukses");
    exit;
}

if (isset($_GET['edit_berita'])) {
    $id_edit = mysqli_real_escape_string($koneksi, $_GET['edit_berita']);
    $q_edit  = mysqli_query($koneksi, "SELECT * FROM berita WHERE id='$id_edit'");
    if (mysqli_num_rows($q_edit) > 0) {
        $edit_berita = mysqli_fetch_assoc($q_edit);
    }
}

if (isset($_POST['simpan_berita'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi   = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $id_berita = $_POST['id_berita'] ?? '';

    $nama_file  = $_FILES['gambar']['name'];
    $tmp_name   = $_FILES['gambar']['tmp_name'];
    $error_file = $_FILES['gambar']['error'];

    $nama_gambar_baru = $edit_berita['gambar'] ?? '';

    if ($error_file === 0) {
        $ekstensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $ekstensi_diizinkan = array('jpg', 'jpeg', 'png', 'webp');

        if (in_array($ekstensi_file, $ekstensi_diizinkan)) {
            $nama_gambar_baru = time() . '_' . $nama_file;
            if (!is_dir('img')) { mkdir('img', 0777, true); }
            move_uploaded_file($tmp_name, 'img/' . $nama_gambar_baru);
        } else {
            $pesan = "Format gambar berita harus JPG, JPEG, PNG, atau WEBP!";
        }
    }

    if (empty($pesan)) {
        if (!empty($id_berita)) {
            $query = "UPDATE berita SET judul='$judul', isi='$isi', gambar='$nama_gambar_baru' WHERE id='$id_berita'";
        } else {
            $query = "INSERT INTO berita (judul, isi, gambar) VALUES ('$judul', '$isi', '$nama_gambar_baru')";
        }

        if (mysqli_query($koneksi, $query)) {
            header("Location: dashboard.php?status=berita_sukses");
            exit;
        } else {
            $pesan = "Gagal menyimpan berita: " . mysqli_error($koneksi);
        }
    }
}


// LOGIKA KELOLA GURU & STAFF (CRUD)
if (isset($_GET['hapus_guru'])) {
    $id_hapus = mysqli_real_escape_string($koneksi, $_GET['hapus_guru']);
    mysqli_query($koneksi, "DELETE FROM guru WHERE id='$id_hapus'");
    header("Location: dashboard.php?status=hapus_guru_sukses");
    exit;
}

if (isset($_GET['edit_guru'])) {
    $id_edit = mysqli_real_escape_string($koneksi, $_GET['edit_guru']);
    $q_edit  = mysqli_query($koneksi, "SELECT * FROM guru WHERE id='$id_edit'");
    if (mysqli_num_rows($q_edit) > 0) {
        $edit_guru = mysqli_fetch_assoc($q_edit);
    }
}

if (isset($_POST['simpan_guru'])) {
    $nama    = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $id_guru = $_POST['id_guru'] ?? '';

    $nama_file  = $_FILES['foto']['name'];
    $tmp_name   = $_FILES['foto']['tmp_name'];
    $error_file = $_FILES['foto']['error'];

    
    $path_foto_baru = $edit_guru['foto'] ?? 'img/default.jpg';

    if ($error_file === 0) {
        $ekstensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $ekstensi_diizinkan = array('jpg', 'jpeg', 'png', 'webp');

        if (in_array($ekstensi_file, $ekstensi_diizinkan)) {
            $nama_foto_unik = time() . '_guru_' . $nama_file;
            if (!is_dir('img')) { mkdir('img', 0777, true); }
            move_uploaded_file($tmp_name, 'img/' . $nama_foto_unik);
            $path_foto_baru = 'img/' . $nama_foto_unik;
        } else {
            $pesan = "Format foto guru harus JPG, JPEG, PNG, atau WEBP!";
        }
    }

    if (empty($pesan)) {
        if (!empty($id_guru)) {
            $query = "UPDATE guru SET nama='$nama', jabatan='$jabatan', foto='$path_foto_baru' WHERE id='$id_guru'";
        } else {
            $query = "INSERT INTO guru (nama, jabatan, foto) VALUES ('$nama', '$jabatan', '$path_foto_baru')";
        }

        if (mysqli_query($koneksi, $query)) {
            header("Location: dashboard.php?status=guru_sukses");
            exit;
        } else {
            $pesan = "Gagal menyimpan data guru: " . mysqli_error($koneksi);
        }
    }
}


$q_stat = mysqli_query($koneksi, "SELECT * FROM statistik WHERE id=1");
$stat_curr = mysqli_fetch_assoc($q_stat);
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
                <i class="fa-solid fa-triangle-exclamation text-sm"></i> <?= $pesan ?>
            </div>
        <?php endif; ?>

        <!-- GRID UTAMA PANEL ADMIN -->
        <div class="grid lg:grid-cols-3 gap-6">

            <div class="lg:col-span-1 space-y-6">
                
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-sm font-bold text-blue-950 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-yellow-500"></i> Update Statistik Sekolah
                    </h2>
                    <form method="POST" class="grid grid-cols-2 gap-3 text-xs">
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Jumlah Guru</label>
                            <input type="number" name="guru" value="<?= $stat_curr['guru'] ?? 22 ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Siswa Laki-Laki</label>
                            <input type="number" name="siswa_laki" value="<?= $stat_curr['siswa_laki'] ?? 100 ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Siswa Perempuan</label>
                            <input type="number" name="siswa_perempuan" value="<?= $stat_curr['siswa_perempuan'] ?? 133 ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Rombel</label>
                            <input type="number" name="rombel" value="<?= $stat_curr['rombel'] ?? 12 ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Daya Tampung</label>
                            <input type="text" name="daya_tampung" value="<?= $stat_curr['daya_tampung'] ?? '180' ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Ruang Kelas</label>
                            <input type="number" name="ruang_kelas" value="<?= $stat_curr['ruang_kelas'] ?? 9 ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Laboratorium</label>
                            <input type="number" name="laboratorium" value="<?= $stat_curr['laboratorium'] ?? 1 ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-semibold mb-1 text-slate-700">Perpustakaan</label>
                            <input type="number" name="perpustakaan" value="<?= $stat_curr['perpustakaan'] ?? 1 ?>" required class="w-full p-2 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="col-span-2 mt-2">
                            <button type="submit" name="update_statistik" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-2.5 rounded-lg transition shadow-sm">
                                Simpan Perubahan Statistik
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-sm font-bold text-blue-950 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-user-tie text-emerald-600"></i>
                        <?= $edit_guru ? 'Edit Guru & Staff' : 'Tambah Guru & Staff' ?>
                    </h2>
                    
                    <form method="POST" enctype="multipart/form-data" class="space-y-3 text-xs">
                        <input type="hidden" name="id_guru" value="<?= $edit_guru['id'] ?? '' ?>">
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama" value="<?= htmlspecialchars($edit_guru['nama'] ?? '') ?>" placeholder="Contoh: Yeni Anisah, S.Pd., MM." required class="w-full p-2.5 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Jabatan / Pengajar</label>
                            <input type="text" name="jabatan" value="<?= htmlspecialchars($edit_guru['jabatan'] ?? '') ?>" placeholder="Contoh: Kepala Sekolah / Guru DKV" required class="w-full p-2.5 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Upload Foto Profil</label>
                            <input type="file" name="foto" accept="image/*" class="w-full p-2 border rounded-lg text-slate-500">
                            <?php if (!empty($edit_guru['foto'])): ?>
                                <p class="text-[10px] text-slate-400 mt-1">* Biarkan kosong jika tidak ingin mengubah foto</p>
                            <?php endif; ?>
                        </div>
                        <button type="submit" name="simpan_guru" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2.5 rounded-lg transition shadow-sm">
                            <?= $edit_guru ? 'Update Data Guru' : 'Simpan Data Guru' ?>
                        </button>
                        <?php if($edit_guru): ?>
                            <a href="dashboard.php" class="block text-center text-slate-500 mt-2 hover:underline">Batal Edit</a>
                        <?php endif; ?>
                    </form>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-sm font-bold text-blue-950 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-pen-to-square text-red-600"></i>
                        <?= $edit_berita ? 'Edit Berita' : 'Tambah Berita' ?>
                    </h2>
                    
                    <form method="POST" enctype="multipart/form-data" class="space-y-3 text-xs">
                        <input type="hidden" name="id_berita" value="<?= $edit_berita['id'] ?? '' ?>">
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Judul Berita</label>
                            <input type="text" name="judul" value="<?= htmlspecialchars($edit_berita['judul'] ?? '') ?>" required class="w-full p-2.5 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Upload Gambar</label>
                            <input type="file" name="gambar" accept="image/*" class="w-full p-2 border rounded-lg text-slate-500">
                        </div>
                        <div>
                            <label class="block font-bold mb-1 text-slate-700">Isi Berita</label>
                            <textarea name="isi" rows="4" required class="w-full p-2.5 border rounded-lg outline-none focus:ring-2 focus:ring-blue-500"><?= htmlspecialchars($edit_berita['isi'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" name="simpan_berita" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-lg transition shadow-sm">
                            <?= $edit_berita ? 'Update Berita' : 'Simpan Berita' ?>
                        </button>
                        <?php if($edit_berita): ?>
                            <a href="dashboard.php" class="block text-center text-slate-500 mt-2 hover:underline">Batal Edit</a>
                        <?php endif; ?>
                    </form>
                </div>

            </div>

            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-sm font-bold text-blue-950 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-users text-emerald-600"></i> Data Guru & Staff Pengajar
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
                                if (mysqli_num_rows($q_guru_list) > 0) {
                                    while ($g = mysqli_fetch_assoc($q_guru_list)) {
                                ?>
                                    <tr>
                                        <td class="p-3">
                                            <img src="<?= file_exists($g['foto']) ? $g['foto'] : 'img/default.jpg' ?>" alt="<?= htmlspecialchars($g['nama']) ?>" class="w-10 h-10 object-cover rounded-full border border-slate-200">
                                        </td>
                                        <td class="p-3 font-bold text-slate-800"><?= htmlspecialchars($g['nama']) ?></td>
                                        <td class="p-3 text-blue-900 font-semibold"><?= htmlspecialchars($g['jabatan']) ?></td>
                                        <td class="p-3 text-center space-x-2 whitespace-nowrap">
                                            <a href="dashboard.php?edit_guru=<?= $g['id'] ?>" class="bg-amber-500 hover:bg-amber-600 text-white px-2.5 py-1 rounded-md text-[10px] font-bold inline-flex items-center gap-1">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </a>
                                            <a href="dashboard.php?hapus_guru=<?= $g['id'] ?>" onclick="return confirm('Yakin ingin menghapus data guru ini?')" class="bg-red-600 hover:bg-red-700 text-white px-2.5 py-1 rounded-md text-[10px] font-bold inline-flex items-center gap-1">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='p-3 text-slate-400 text-center'>Belum ada data guru.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-sm font-bold text-blue-950 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-newspaper text-blue-900"></i> Daftar Berita Diterbitkan
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
                                if (mysqli_num_rows($q_berita) > 0) {
                                    while ($b = mysqli_fetch_assoc($q_berita)) {
                                ?>
                                    <tr>
                                        <td class="p-3 text-slate-500 whitespace-nowrap"><?= date('d M Y', strtotime($b['created_at'])) ?></td>
                                        <td class="p-3 font-semibold text-slate-800"><?= htmlspecialchars($b['judul']) ?></td>
                                        <td class="p-3 text-center space-x-2 whitespace-nowrap">
                                            <a href="dashboard.php?edit_berita=<?= $b['id'] ?>" class="bg-amber-500 hover:bg-amber-600 text-white px-2.5 py-1 rounded-md text-[10px] font-bold inline-flex items-center gap-1">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </a>
                                            <a href="dashboard.php?hapus_berita=<?= $b['id'] ?>" onclick="return confirm('Yakin ingin menghapus berita ini?')" class="bg-red-600 hover:bg-red-700 text-white px-2.5 py-1 rounded-md text-[10px] font-bold inline-flex items-center gap-1">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='p-3 text-slate-400 text-center'>Belum ada berita.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h2 class="text-sm font-bold text-blue-950 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-blue-900"></i> Pesan Masuk Pengunjung
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b text-slate-600">
                                    <th class="p-3">Nama / Email</th>
                                    <th class="p-3">Subjek</th>
                                    <th class="p-3">Pesan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <?php
                                $q_kontak = mysqli_query($koneksi, "SELECT * FROM kontak ORDER BY id DESC LIMIT 5");
                                if (mysqli_num_rows($q_kontak) > 0) {
                                    while ($k = mysqli_fetch_assoc($q_kontak)) {
                                ?>
                                    <tr>
                                        <td class="p-3 font-bold text-slate-800">
                                            <?= htmlspecialchars($k['nama']) ?><br>
                                            <span class="text-[10px] text-blue-600 font-normal"><?= htmlspecialchars($k['email']) ?></span>
                                        </td>
                                        <td class="p-3 text-slate-700 font-semibold"><?= htmlspecialchars($k['subjek']) ?></td>
                                        <td class="p-3 text-slate-600"><?= htmlspecialchars($k['pesan']) ?></td>
                                    </tr>
                                <?php 
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='p-3 text-slate-400 text-center'>Belum ada pesan masuk.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</body>
</html>