<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

    $query = "INSERT INTO feedback (nama, email, pesan) VALUES ('$nama', '$email', '$pesan')";

    echo "<link rel='stylesheet' href='../style.css'>";

    if (mysqli_query($conn, $query)) {
        // Notifikasi Sukses Estetik di Tengah
        echo "<div class='notif-center success'>✨ Pesan terkirim! Terima kasih atas masukannya.</div>";
        echo "<script>
                setTimeout(function() {
                    window.location.href = '../contact.html';
                }, 3000);
              </script>";
    } else {
        echo "<div class='notif-center error'>❌ Gagal mengirim pesan. Silakan coba lagi.</div>";
        echo "<script>
                setTimeout(function() {
                    window.history.back();
                }, 3000);
              </script>";
    }
}
?>