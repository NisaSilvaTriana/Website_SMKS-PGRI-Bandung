<?php
// Proteksi Cookie Session (Anti Cookie Theft / Anti XSS Theft)
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_samesite', 'Lax');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "localhost"; 
$user = "root"; 
$pass = "";  
$db   = "db_sekolah";       

// Sembunyikan pesan error database internal
mysqli_report(MYSQLI_REPORT_OFF);
$koneksi = @mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    error_log("Database Connection Error: " . mysqli_connect_error());
    die("Koneksi ke server bermasalah. Silakan coba beberapa saat lagi.");
}

mysqli_set_charset($koneksi, "utf8mb4");

// Helper Global Sanitasi Output (Anti-XSS)
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

// Helper CSRF Protection
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
        die("Akses Ditolak: Validasi keamanan (CSRF Token) gagal.");
    }
}
?>