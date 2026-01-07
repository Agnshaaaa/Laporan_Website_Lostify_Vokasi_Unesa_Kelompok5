<?php
session_start();
include "config.php"; // Pastikan koneksi database benar

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // Sebaiknya gunakan password_verify jika di-hash

    // Query cek user
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_assoc($query);
        
        // Simpan data ke session
        $_SESSION['username'] = $row['username'];
        $_SESSION['status'] = "login";

        // Alihkan ke halaman utama (Dashboard)
        header("Location: index.php");
        exit();
    } else {
        // Jika gagal, balik ke login dengan pesan error
        header("Location: login.html?error=wrong");
        exit();
    }
}
?>