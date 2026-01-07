<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
# koneksi database
$conn = mysqli_connect("localhost", "root", "", "lostify_db");

if (!$conn) {
    die("Koneksi gagal");
}
?>
