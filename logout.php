<?php
session_start(); // Memulai sesi agar bisa dihapus
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Menghancurkan sesi secara total

// Otomatis kembali ke halaman login (sesuaikan dengan nama file login Anda)
header("Location: ../login.html");
exit();
?>