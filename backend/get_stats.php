<?php
include "../config.php"; # Hubungkan koneksi

$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM items"))['jml'];
$hilang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM items WHERE kategori='hilang'"))['jml'];
$temu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM items WHERE kategori='temuan'"))['jml'];

# Output dalam format JSON untuk dibaca Javascript
echo json_encode([
    "total" => $total,
    "hilang" => $hilang,
    "temuan" => $temu
]);
?>