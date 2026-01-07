<?php
include "../config.php"; # koneksi
session_start();

$id = $_SESSION['user_id'];
mysqli_query($conn, "DELETE FROM users WHERE id='$id'"); # hapus akun

session_destroy();
echo "akun dihapus";
?>
