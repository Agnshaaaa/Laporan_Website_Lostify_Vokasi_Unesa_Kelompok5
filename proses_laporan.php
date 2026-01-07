<?php
include "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $tipe   = mysqli_real_escape_string($conn, $_POST['tipe']);
    $nama   = mysqli_real_escape_string($conn, $_POST['nama_barang']);
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $tgl    = $_POST['tanggal'];
    $desc   = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak']);
    
    // Urusan Upload Foto
    $foto_name = "";
    if (!empty($_FILES['foto']['name'])) {
        $foto_name = time() . "_" . $_FILES['foto']['name'];
        // Pastikan folder 'uploads' sudah ada di folder utama
        move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/" . $foto_name);
    }

    // Query INSERT (is_verified diset 1 agar langsung muncul)
    $sql = "INSERT INTO laporan_barang (tipe_laporan, nama_barang, lokasi, tanggal, deskripsi, foto, kontak_pelapor, is_verified) 
            VALUES ('$tipe', '$nama', '$lokasi', '$tgl', '$desc', '$foto_name', '$kontak', 1)";

    $eksekusi = mysqli_query($conn, $sql);

    // KIRIM RESPON TEKS UNTUK AJAX (Wajib echo 'success' agar notif jadi hijau)
    if ($eksekusi) {
        echo "success";
    } else {
        echo "error";
    }
}
?>