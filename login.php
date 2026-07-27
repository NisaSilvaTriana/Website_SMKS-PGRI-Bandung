<?php
include 'koneksi.php';

if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

// Rate Limiting: Maksimal 5x percobaan salah per 15 menit
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

if ($_SESSION['login_attempts'] >= 5 && (time() - $_SESSION['last_attempt_time']) < 900) {
    $sisa_waktu = ceil((900 - (time() - $_SESSION['last_attempt_time'])) / 60);
    $error = "Terlalu banyak percobaan salah. Silakan coba lagi dalam $sisa_waktu menit.";
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        verify_csrf_token($_POST['csrf_token'] ?? '');

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Prepared Statement Anti-SQL Injection
        $stmt = mysqli_prepare($koneksi, "SELECT id, username, password FROM users WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            // Cek BCrypt Hash dengan Fallback ke String Plaintext lama
            if (password_verify($password, $row['password']) || $password === $row['password']) {
                session_regenerate_id(true); // Anti Session Fixation
                
                $_SESSION['admin_login'] = true;
                $_SESSION['admin_id'] = $row['id'];
                $_SESSION['admin_username'] = $row['username'];
                $_SESSION['login_attempts'] = 0;

                header("Location: dashboard.php");
                exit;
            }
        }

        $_SESSION['login_attempts'] += 1;
        $_SESSION['last_attempt_time'] = time();
        $error = "Username atau password salah!";
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SMKS PGRI Bandung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md border border-slate-200">
        <div class="text-center mb-6">
            <img src="img/logo.png" alt="Logo PGRI" class="w-14 h-14 object-contain mx-auto mb-2">
            <h2 class="text-2xl font-black text-blue-950">Login Admin</h2>
            <p class="text-slate-500 text-xs mt-1">SMKS PGRI Bandung Management System</p>
        </div>
        
        <?php if (isset($_GET['status']) && $_GET['status'] == 'logout') : ?>
            <div class="bg-emerald-100 text-emerald-800 p-3 rounded-xl mb-4 text-xs font-semibold text-center flex items-center justify-center gap-2">
                <i class="fa-solid fa-circle-check"></i> Anda telah berhasil keluar dari sistem.
            </div>
        <?php endif; ?>

        <?php if ($error) : ?>
            <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4 text-xs font-semibold text-center flex items-center justify-center gap-2">
                <i class="fa-solid fa-triangle-exclamation"></i> <?= e($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?= generate_csrf_token() ?>">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Username Admin</label>
                <div class="relative">
                    <input type="text" name="username" placeholder="Masukkan username" required class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <i class="fa-solid fa-user absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                <div class="relative">
                    <input type="password" name="password" placeholder="Masukkan password" required class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                    <i class="fa-solid fa-lock absolute left-3.5 top-3.5 text-slate-400 text-xs"></i>
                </div>
            </div>

            <button type="submit" name="login" class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-2.5 rounded-xl text-sm transition shadow-md flex items-center justify-center gap-2">
                <i class="fa-solid fa-right-to-bracket text-xs"></i> Masuk ke Dashboard
            </button>
        </form>

        <div class="text-center mt-6 pt-4 border-t border-slate-100">
            <a href="index.php" class="text-xs font-bold text-blue-900 hover:text-red-600 transition flex items-center justify-center gap-1">
                <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Website Utama
            </a>
        </div>
    </div>

</body>
</html>