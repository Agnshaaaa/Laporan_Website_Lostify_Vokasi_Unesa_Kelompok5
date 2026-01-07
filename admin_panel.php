<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Lostify</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">LOSTIFY ADMIN</div>
        <nav class="nav-links">
            <a href="index.php">Kembali ke User Site</a>
        </nav>
    </header>

    <main style="padding: 20px 50px;">
        <div class="welcome-banner" style="border-left: 10px solid #FF4444;">
            <h1>Verifikasi <span>Laporan Masuk</span></h1>
            <p>Tinjau setiap laporan sebelum ditampilkan ke halaman publik.</p>
        </div>

        <div class="stat-card" style="margin-top: 30px;">
            <h3>📩 Pesan Kendala & Masukan</h3>
            <table style="width: 100%; border-collapse: collapse; text-align: left; margin-top: 15px;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--kuning);">
                        <th style="padding: 10px;">Nama</th>
                        <th>Email</th>
                        <th>Pesan</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Mengambil data dari tabel feedback
                    $q_saran = mysqli_query($conn, "SELECT * FROM feedback ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($q_saran)) {
                        echo "<tr style='border-bottom: 1px solid #444;'>";
                        echo "<td style='padding: 15px;'>{$row['nama']}</td>";
                        echo "<td>{$row['email']}</td>";
                        echo "<td>{$row['pesan']}</td>";
                        echo "<td>{$row['tanggal']}</td>";
                        echo "</tr>";
                    }
                    if(mysqli_num_rows($q_saran) == 0) echo "<tr><td colspan='4' style='padding:20px; text-align:center;'>Belum ada masukan yang masuk.</td></tr>";
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>