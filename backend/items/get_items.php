<?php
include "../../config.php"; # koneksi

$q = mysqli_query($conn, "SELECT * FROM items ORDER BY id DESC");
$data = [];

while ($row = mysqli_fetch_assoc($q)) {
    $data[] = $row; # simpan ke array
}

echo json_encode($data); # kirim ke frontend
?>
