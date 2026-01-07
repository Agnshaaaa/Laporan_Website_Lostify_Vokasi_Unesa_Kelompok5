<?php
include "../../config.php"; # koneksi

$user = $_POST['user_id'];
$nama = $_POST['nama_barang'];
$desk = $_POST['deskripsi'];
$status = $_POST['status'];

mysqli_query($conn,
 "INSERT INTO items (user_id,nama_barang,deskripsi,status,tanggal)
  VALUES ('$user','$nama','$desk','$status',CURDATE())"
);

echo "item ditambahkan";
?>
