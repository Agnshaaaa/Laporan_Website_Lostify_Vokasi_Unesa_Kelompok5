<?php
include "../../config.php"; # koneksi
session_start();

$id = $_SESSION['user_id'];

$q = mysqli_query($conn, "SELECT username,email,photo FROM users WHERE id='$id'");
echo json_encode(mysqli_fetch_assoc($q)); # data profil
?>
