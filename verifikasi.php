<?php
include "../config.php";

$id = $_GET['id'];
$action = $_GET['action'];

if ($action == 'setuju') {
    // Ubah is_verified menjadi 1 agar tampil di publik
    mysqli_query($conn, "UPDATE laporan_barang SET is_verified = 1 WHERE id = $id");
} else {
    // Hapus laporan jika ditolak
    mysqli_query($conn, "DELETE FROM laporan_barang WHERE id = $id");
}

header("Location: ../admin_panel.php");
exit();
?>