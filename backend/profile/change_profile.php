<?php
include "../../config.php"; # koneksi
session_start();

$id = $_SESSION['user_id'];
$foto = $_FILES['photo']['name'];

move_uploaded_file($_FILES['photo']['tmp_name'], "../../images/$foto");

mysqli_query($conn,
 "UPDATE users SET photo='$foto' WHERE id='$id'"
);

echo "foto diganti";
?>
