<?php
include "../config.php"; # Hubungkan koneksi database

$nama      = $_POST['nama_lengkap'];
$username  = $_POST['username'];
$email     = $_POST['email'];
$no_telp   = $_POST['no_telp'];
$prodi     = $_POST['prodi'];
$password  = password_hash($_POST['password'], PASSWORD_DEFAULT);

$check_email = mysqli_query($conn, "SELECT email FROM users WHERE email='$email'");

echo "<link rel='stylesheet' href='../style.css'>"; # Memanggil CSS

if (mysqli_num_rows($check_email) > 0) {
    # Gagal: Email Duplikat (Merah)
    echo "<div class='notification-error'>Email sudah terdaftar! Gunakan email lain.</div>";
    echo "<script>
            setTimeout(function() {
                window.history.back();
            }, 2000);
          </script>";
} else {
    $query = "INSERT INTO users (nama_lengkap, username, email, no_telp, password, prodi) 
              VALUES ('$nama', '$username', '$email', '$no_telp', '$password', '$prodi')";

    if (mysqli_query($conn, $query)) {
        # Sukses: Register Berhasil (Hijau)
        echo "<div class='notification-success'>Register Berhasil! Silakan Login.</div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = '../login.html';
                }, 2000);
              </script>";
    } else {
        echo "<div class='notification-error'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>