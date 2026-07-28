SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `berita` (`id`, `judul`, `isi`, `gambar`, `created_at`) VALUES
(1, 'Penerimaan Peserta Didik Baru (PPDB) SMKS PGRI Bandung Tahun Ajaran 2026/2027 Resmi Dibuka', 'SMKS PGRI Bandung kembali membuka pendaftaran untuk calon peserta didik baru. Tersedia 4 Konsentrasi Keahlian unggulan yaitu MPLB, DKV, Bisnis Digital, dan AKL. Dapatkan kemudahan pendaftaran serta program beasiswa khusus bagi pendaftar gelombang pertama.', NULL, '2026-05-10 01:00:00'),
(2, 'Pelaksanaan Penilaian Sumatif Akhir Semester dan Uji Kompetensi Keahlian (UKK) Siswa', 'Siswa-siswi kelas XII SMKS PGRI Bandung melaksanakan Uji Kompetensi Keahlian (UKK) berbasis standar industri. Kegiatan ini bekerja sama dengan mitra DU/DI terkemuka di Kota Bandung untuk memastikan kelulusan siswa siap kerja dan bersaing secara profesional.', NULL, '2026-03-24 02:30:00'),
(3, 'Tingkatkan Program SPW dan Penerapan Kurikulum Merdeka, SMK PGRI Kota Bandung Siap Cetak Lulusan Mandiri dan Kompeten', '<b>KOTA BANDUNG</b> — Masa Penerimaan Peserta Didik Baru (PPDB) dan Masa Pengenalan Lingkungan Sekolah (MPLS) telah usai. Mulai Senin, 22 Juli 2024, kegiatan belajar mengajar (KBM) Tahun Ajaran 2024/2025 di SMK PGRI Kota Bandung telah resmi berjalan secara efektif.\r\n\r\nPada tahun ajaran baru ini, SMK PGRI Kota Bandung sebagai salah satu sekolah vokasi top di Kota Bandung di bawah naungan Yayasan PGRI fokus meningkatkan berbagai program unggulan, mulai dari penguatan wirausaha siswa hingga adaptasi penuh Kurikulum Merdeka.\r\n\r\nFokus Peningkatan Program Sekolah Pencetak Wirausaha (SPW)\r\n\r\nKepala SMK PGRI Kota Bandung, Yeni Anisah, S.Pd., M.M., menjelaskan bahwa pada TA 2024/2025 pihak sekolah lebih fokus pada peningkatan program Sekolah Pencetak Wirausaha (SPW). Program ini merupakan salah satu program unggulan yang diselenggarakan setiap tahun dan sangat diminati oleh para siswa.\r\n\r\n\"<i>Ini akan terus dilanjutkan. Kemarin siswa kelas XI ada yang mencapai 20 juta rupiah omsetnya. Kita menjadi peringkat ke 3 PGRI se-Jawa Barat. Juga mendapat reward dari yayasan berupa sertifikat kompetensi. Karena nyambung dari mapel Projek Kreatif Kewirausahaan (PKK). PKK itu menilainya sesuai omset. Dan sudah pasti ini semua jurusan yang ada di PGRI yah</i>,\" kata Yeni saat ditemui di ruang kerjanya di Jalan Kencanawangi Utara No 22, Kelurahan Cijawura, Kecamatan Buahbatu.\r\n\r\nLebih lanjut, Yeni menerangkan inovasi program unggulan lainnya berupa kolaborasi antara mapel PKK dengan mata pelajaran pilihan bagi siswa kelas XII, yaitu kuliner. Pemilihan bidang kuliner didasari oleh banyaknya siswa SMK PGRI Kota Bandung yang gemar memasak. Pihak sekolah berencana mendatangkan tenaga ahli untuk mengajar para siswa.\r\n\r\n\"<i>Agar siswa tidak hanya bisa memasak seblak saja</i>,\" ujar Yeni.\r\n\r\nMata pelajaran pilihan kuliner ini merupakan hal baru bagi kelas XII seiring dengan penerapan Kurikulum Merdeka, mengingat pada tahun sebelumnya kelas XII masih menggunakan Kurikulum 2013 sehingga belum ada mata pelajaran pilihan. Pengkolaborasian ini ditujukan untuk memajukan program SPW.\r\n\r\n\"<i>SPW akan selalu saya pantau. Dari kuliner, produk siswa untuk dijual. Karena mereka sebetulnya senang berjualan. Sehingga kalau ada gurunya, mereka memasak atau bikin kue itu bisa lebih menarik. Kalau tata boga itu ada ilmunya kan, hingga menarik konsumen dari segi tampilan makanan itu seperti apa</i>,\" ungkap Yeni.\r\n\r\nMelalui program SPW ini, Yeni berharap lulusan SMK PGRI Kota Bandung tidak hanya dipersiapkan untuk bekerja, tetapi juga mampu melanjutkan kuliah atau berwirausaha (<b>startup</b>) sehingga bisa membuka lowongan pekerjaan dan merekrut rekan-rekannya.\r\n\r\nPelaksanaan PKL Kelas XII Selama 6 Bulan Menurut Bidang Hubin\r\n\r\nWakil Kepala Sekolah bidang Hubungan Industri (Hubin), Sani Marni Sari Banon, S.Sos., M.Pd., Gr., menjelaskan perbedaan pelaksanaan program Hubin tahun ini sesuai dengan kebijakan Kemendikbud terkait Praktik Kerja Lapangan (PKL).\r\n\r\n\"<i>Perbedaannya, sesuai dengan Kemendikbud, tentang pelaksanaan Praktek Kerja Lapangan atau PKL. Semula dilaksanakannya di kelas XI. Namun sekarang di kelas XII, itu selama enam bulan. Kami juga belum bisa evaluasi ini efektif atau tidak karena ini baru pertama kali dilaksanakan</i>,\" papar Sani.\r\n\r\nTahun ini, sebanyak 54 siswa kelas XII dari jurusan Manajemen Perkantoran dan Lembaga Bisnis (MPLB), Desain Komunikasi Visual (DKV), dan Akuntansi Keuangan Lembaga (AKL) mengikuti PKL. Hal ini membuat jadwal belajar siswa kelas XII menjadi lebih padat dengan masa efektif belajar sekitar sembilan bulan.\r\n\r\n\"<i>Setelah PKL ada sidang. Setelah sidang mereka mempersiapkan ujian akhir semester. Kemudian sesudahnya ada uji kompetensi keahlian. Sesudahnya ada pemantapan untuk ujian sekolah. Tidak ada keluhan atau kendala untuk prosedur baru ini dari jajaran Hubin. Hanya adaptasi saja mungkin</i>,\" tutur Sani.\r\n\r\nSani meyakini para siswa mampu beradaptasi dengan cepat. Apalagi pihak sekolah telah menjalin kerja sama (MoU) dengan berbagai instansi dan perusahaan. Ke depan, SMK PGRI Kota Bandung juga merencanakan kegiatan pengujian kompetensi seperti Lomba Kompetensi Siswa (LKS) guna membentuk mental siswa yang siap kerja.\r\n\r\nPenerapan Penuh Kurikulum Merdeka dan Jumlah Siswa Baru\r\n\r\nDari segi akademik, Wakil Kepala Sekolah bidang Kurikulum, Melly Irnawati, S.Si., M.H., menyampaikan bahwa Kurikulum Merdeka tahun ini diimplementasikan secara menyeluruh untuk semua tingkatan (kelas X, XI, dan XII).\r\n\r\n\"<i>Di tahun sebelumnya kelas XII itu masih Kurtilas. Namun sekarang semuanya sudah Kurikulum Merdeka. Oleh karena itu banyak kelas XII yang sedang PKL</i>,\" jelas Melly. Sementara itu, siswa kelas X dan XI tetap menjalani KBM seperti biasa di sekolah.\r\n\r\nMelly berharap pelaksanaan PKL di kelas XII dapat mengaplikasikan keahlian siswa secara langsung di dunia industri, sehingga etos kerja yang terbangun dapat terus terjaga hingga kelulusan tanpa memerlukan adaptasi ekstra saat memasuki dunia kerja.\r\n\r\n\"<i>Kalau program itu kurang lebih masih sama. Seperti di awal tahun ajaran ada KBM. Kemudian nanti ada ANBK. Lalu ada sumatif akhir semester guna mengukur ketercapaian siswa. Serta sumatif akhir tahun, itu ada di semester ganjil dan genap</i>,\" tambah Melly.\r\n\r\nPada Tahun Ajaran 2024/2025, jumlah siswa baru kelas X SMK PGRI Kota Bandung mengalami peningkatan menjadi 70 orang (naik dari 50 siswa di tahun sebelumnya). Rinciannya meliputi:\r\n\r\n<b>Manajemen Perkantoran dan Lembaga Bisnis (MPLB)</b>: 14 siswa\r\n<b>Pemasaran</b>: 20 siswa\r\n<b>Desain Komunikasi Visual (DKV)</b>: 21 siswa\r\n<b>Akuntansi dan Keuangan Lembaga (AKL)</b>: 15 siswa\r\n\r\nDengan total keseluruhan 209 siswa aktif di tahun 2024, Melly berharap seluruh peserta didik SMK PGRI Kota Bandung siap kerja, lebih mandiri, dan kreatif.\r\n\r\n\"<i>Apapun perubahan kurikulumnya tetap dapat dimanfaatkan dengan baik</i>,\" kata Melly.\r\n\"<i>Setiap siswa diharapkan dapat mengikuti setiap pembelajaran. Karena setiap guru memiliki gaya pembelajaran yang berbeda-beda. Itu semua dipilih sebagai yang terbaik dalam penyampaian materi kepada para siswa</i>,\" pungkasnya.', '1785206059_69bdfb99f0002daf.jpeg', '2024-07-22 16:57:00'),
(4, 'Kegiatan Sosialisasi Literasi Digital dan Karakter Disiplin Bersama Yayasan PGRI', 'Dalam rangka membentuk peserta didik yang tidak hanya kompeten secara teknis tetapi juga berakhlak mulia, SMKS PGRI Bandung menyelenggarakan pembinaan karakter dan pembiasaan positif mingguan bagi seluruh warga sekolah.', NULL, '2026-01-12 00:45:00');

CREATE TABLE `ekskul` (
  `id` int(11) NOT NULL,
  `nama_ekskul` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `ekskul` (`id`, `nama_ekskul`, `deskripsi`) VALUES
(1, 'Pramuka', 'Membentuk karakter disiplin dan mandiri.'),
(2, 'Paskibra', 'Kedisiplinan tinggi dan persiapan pengibaran bendera.'),
(3, 'Futsal', 'Mengembangkan bakat olahraga dan kerja sama tim.'),
(4, 'IRMA', 'Ikatan Remaja Masjid untuk memperdalam nilai-nilai keagamaan, akhlak mulia, dan kegiatan kerohanian Islam.'),
(5, 'Pencak Silat', 'Mengembangkan ketangkasan bela diri tradisional, kedisiplinan fisik, mental, dan pelestarian budaya bangsa.'),
(6, 'Voli', 'Melatih kerja sama tim, ketahanan fisik, ketangkasan, dan strategi permainan olahraga bola voli.'),
(7, 'Basket', 'Mengasah keterampilan teknik dasar basket, kelincahan, sportivitas, dan kerja sama tim yang solid.'),
(8, 'Karawitan', 'Wadah pelestarian seni musik tradisional Sunda/Jawa melalui latihan instrumen gamelan dan kesenian daerah.'),
(9, 'Tari', 'Mengembangkan bakat seni tari tradisional dan modern serta melatih keluwesan dan ekspresi seni peserta didik.');

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `guru` (`id`, `nama`, `jabatan`, `foto`) VALUES
(1, 'Yeni Anisah, S.Pd., MM.', 'Kepala Sekolah', 'img/kepala-sekolah.jpg');

CREATE TABLE `kontak` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subjek` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `statistik` (
  `id` int(11) NOT NULL,
  `guru` int(11) NOT NULL DEFAULT 22,
  `siswa_laki` int(11) NOT NULL DEFAULT 100,
  `siswa_perempuan` int(11) NOT NULL DEFAULT 133,
  `rombel` int(11) NOT NULL DEFAULT 12,
  `daya_tampung` varchar(20) NOT NULL DEFAULT '180',
  `ruang_kelas` int(11) NOT NULL DEFAULT 9,
  `laboratorium` int(11) NOT NULL DEFAULT 1,
  `perpustakaan` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `statistik` (`id`, `guru`, `siswa_laki`, `siswa_perempuan`, `rombel`, `daya_tampung`, `ruang_kelas`, `laboratorium`, `perpustakaan`) VALUES
(1, 22, 100, 133, 12, '180', 9, 1, 1);

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'u123456789_admin_sekolah', 'SmksPgriBandung15!');

ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ekskul`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `statistik`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `ekskul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `statistik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;
