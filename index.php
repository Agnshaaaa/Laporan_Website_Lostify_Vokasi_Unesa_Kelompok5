<?php
session_start();

// Proteksi: Jika tidak ada session username, balikkan ke login
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

include "config.php";
$username = $_SESSION['username'];
// Menghitung statistik dari database
$query_total = mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan_barang WHERE is_verified = 1");
$total_laporan = mysqli_fetch_assoc($query_total)['jml'];

$query_hilang = mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan_barang WHERE tipe_laporan = 'hilang' AND is_verified = 1");
$total_hilang = mysqli_fetch_assoc($query_hilang)['jml'];

$query_temu = mysqli_query($conn, "SELECT COUNT(*) as jml FROM laporan_barang WHERE tipe_laporan = 'temu' AND is_verified = 1");
$total_temu = mysqli_fetch_assoc($query_temu)['jml'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>LOSTIFY Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <button id="dark-toggle">🌙 Mode Gelap</button>

    <header class="navbar" style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: #1a1a1aff;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <div class="logo" style="font-weight: bold; font-size: 20px;">LOSTIFY</div>
        </div>
        
        <nav class="nav-links" style="flex-grow: 1; display: flex; justify-content: center;">
            <a href="index.php">Dashboard</a>
            <a href="barang_hilang.php">Barang Hilang</a>
            <a href="barang_temu.php">Barang Temu</a>
            <a href="admin_panel.php" style="color: #FF4444; font-weight: bold;">⚠️ Admin</a>
        </nav>
        <div class="user-profile" style="margin-left: 20px; white-space: nowrap;">
            <a href="profile.php" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                Halo, <strong><?php echo $username; ?></strong> 🐼</div>
            </a>  
        </div>  
    </header>

    <main>
        <section class="welcome-banner">
            <h1>Welcome to Lostify <span><?php echo $username; ?>!</span></h1> 
            <p>Sistem Laporan Barang Hilang & Ditemukan Vokasi UNESA. ✨</p>
            <div style="margin-top: 20px;">
                <button style="background:var(--kuning); padding:10px 20px; border:none; border-radius:8px; font-weight:bold; cursor:pointer;">
                    📦 Tambah Laporan</button>
            </div>
        </section>

        <div class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">
            <div class="stat-card">
                <p>Total Laporan</p>
                <h2><?php echo $total_laporan; ?></h2>
            </div>

            <div class="stat-card">
                <p>🔍 Barang Hilang</p>
                <h2><?php echo $total_hilang; ?></h2>
            </div>

            <div class="stat-card">
                <p>📍 Barang Ditemukan</p>
                <h2><?php echo $total_temu; ?></h2>
            </div>

            <div class="stat-card">
                <p>⏱️ Hari Aktif</p>
                <h2>1</h2>
            </div>
        </div>
</div>

        <section class="info-box" style="margin: 30px 50px; padding: 20px; background: white; border-radius: 15px; border-left: 5px solid var(--kuning);">
            <h3>📢 Informasi Pengambilan Barang</h3>
            <p>Barang temuan yang telah diverifikasi akan disimpan di <strong>Loker Kehilangan (Security Center)</strong>. Silakan tunjukkan bukti identitas untuk pengambilan.</p>
        </section>
    </main>
<footer class="footer-container">
    <div class="footer-content">
        <div class="footer-brand">
            <h2>LOSTIFY – Vokasi UNESA</h2>
            <p>Lostify membantu mahasiswa Vokasi UNESA untuk melaporkan barang hilang, mencatat temuan, dan mempercepat proses pengembalian barang secara efisien.</p>
        </div>
        
        <div class="footer-links">
            <h3>Navigasi Cepat</h3>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
        
        <div class="footer-contact">
            <h3>Kontak</h3>
            <p>📧 support@lostify-unesa.com</p>
            <p>🎓 Universitas Negeri Surabaya - Kampus Ketintang</p>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; 2026 Lostify. All rights reserved.</p>
        <p>v1.0.0</p>
    </div>
</footer>
    <script src="script.js"></script>
</body>
</html>