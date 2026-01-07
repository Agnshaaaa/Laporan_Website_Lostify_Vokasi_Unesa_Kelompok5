<?php
// Naik satu tingkat ambil config
include "../config.php"; 

$identity = $_POST['identity']; 
$password = $_POST['password'];

$q = mysqli_query($conn, "SELECT * FROM users WHERE email='$identity' OR username='$identity'");
$user = mysqli_fetch_assoc($q);

echo "<link rel='stylesheet' href='../style.css'>";

if ($user && password_verify($password, $user['password'])) {
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username']; 
    
    echo "<div class='notification-success' style='position: fixed; top: 20px; right: 20px; background: #2ecc71; color: white; padding: 15px; border-radius: 8px; z-index: 9999;'>Login Berhasil! Menuju Dashboard...</div>";
    echo "<script>
            setTimeout(function() {
                window.location.href = '/lostify/index.php';
            }, 1500);
          </script>";
} else {
    echo "<div class='notification-error' style='position: fixed; top: 20px; right: 20px; background: #e74c3c; color: white; padding: 15px; border-radius: 8px; z-index: 9999;'>Login Gagal! Akun tidak ditemukan.</div>";
    echo "<script>
            setTimeout(function() {
                window.location.href = '/lostify/login.html';
            }, 1500);
          </script>";
}
?>