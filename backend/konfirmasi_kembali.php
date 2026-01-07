<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);

    // 1. Hapus data dari inventaris temuan berdasarkan ID
    $deleteTemu = mysqli_query($conn, "DELETE FROM laporan_barang WHERE id = '$id'");

    // 2. Hapus data otomatis di barang_hilang jika nama barang mirip/sama
    $deleteHilang = mysqli_query($conn, "DELETE FROM laporan_barang WHERE tipe_laporan = 'hilang' AND nama_barang LIKE '%$nama%'");

    if ($deleteTemu) {
        echo "success";
    } else {
        echo "error";
    }
}
?>