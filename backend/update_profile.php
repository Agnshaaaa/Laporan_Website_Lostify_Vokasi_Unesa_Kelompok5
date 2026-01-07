<?php
session_start();
include "../config.php"; // Pastikan path ke config benar

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_SESSION['username'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = $_POST['new_password'];

    // Jika user mengisi password baru
    if (!empty($new_password)) {
        // Enkripsi password untuk keamanan
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET email='$email', password='$hashed_password' WHERE username='$username'";
    } else {
        // Hanya update email jika password kosong
        $query = "UPDATE users SET email='$email' WHERE username='$username'";
    }

    if (mysqli_query($conn, $query)) {
        // Berhasil, kembali ke profil dengan status sukses
        header("Location: ../profile.php?status=success");
    } else {
        // Gagal karena error database
        header("Location: ../profile.php?status=error");
    }
} else {
    // Jika diakses langsung tanpa POST
    header("Location: ../profile.php");
}
exit();
?>