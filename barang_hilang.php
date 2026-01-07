<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Barang Hilang - Lostify</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? 'dark' : ''; ?>">
    <div id="notifArea"></div>

    <header class="navbar">
        <div class="logo">LOSTIFY</div>
        <nav class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="barang_hilang.php" class="active">Barang Hilang</a>
            <a href="barang_temu.php">Barang Temu</a>
            <a href="admin_panel.php" style="color: #FF4444; font-weight: bold;">⚠️ Admin</a>
        </nav>
    </header>

    <main style="padding: 20px 50px;">
        <div class="welcome-banner">
            <h1>Cari Barang <span>Hilang!</span></h1>
            <p>Berikan detail sejelas mungkin agar barang Anda lebih mudah diidentifikasi.</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
            <div class="stat-card" style="border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.05); text-align: left; padding: 40px;">
                <h3 style="display: flex; align-items: center; gap: 10px; margin-bottom: 25px;">
                    <span style="background: var(--kuning); padding: 8px; border-radius: 8px;">📦</span> 
                    Form Laporan Kehilangan
                </h3>
                <form id="formPostingHilang" enctype="multipart/form-data">
                    <input type="hidden" name="tipe" value="hilang">
                    <div class="input-group">
                        <input type="text" name="nama_barang" placeholder="Nama Barang (Contoh: Kunci Motor)" required>
                        <input type="text" name="lokasi" placeholder="Lokasi Terakhir Terlihat (Contoh: Kantin)" required>
                        <div style="display: flex; gap: 15px;">
                            <input type="date" name="tanggal" style="flex: 1;" required>
                            <input type="text" name="kontak" placeholder="WhatsApp/ID Line" style="flex: 1;" required>
                        </div>
                        <textarea name="deskripsi" placeholder="Ciri-ciri khusus barang..." style="height: 100px;"></textarea>
                        
                        <div style="background: #f9f9f9; padding: 15px; border-radius: 8px; border: 1px dashed #ddd; margin: 15px 0;">
                            <label style="font-size: 13px; font-weight: 600; color: #666;">📸 Upload Foto Barang (Opsional)</label>
                            <input type="file" name="foto" accept="image/*" style="border: none; padding: 10px 0;">
                        </div>
                        
                        <button type="submit" style="background: var(--hitam); color: var(--kuning); width: 100%; padding: 15px; border-radius: 12px; font-size: 16px; letter-spacing: 1px; cursor: pointer; border: none; font-weight: bold;">
                            Posting Kehilangan
                        </button>
                    </div>
                </form>
            </div>

            <div class="stat-card">
                <h3>🔍 Sedang Dicari</h3>
                <div id="listBarangHilang" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-top: 15px; width: 100%;">
                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM laporan_barang WHERE tipe_laporan='hilang' AND is_verified=1 ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($q)) {
                        echo "<div style='border: 1px solid var(--kuning); padding: 15px; border-radius: 10px; text-align: left;'>";
                        echo "<h4 style='color: var(--kuning);'>{$row['nama_barang']}</h4>";
                        echo "<p style='font-size: 12px;'>📍 {$row['lokasi']} | 📅 {$row['tanggal']}</p>";
                        echo "<p style='font-size: 13px;'>📞 Hub: {$row['kontak_pelapor']}</p>";
                        echo "</div>";
                    }
                    if(mysqli_num_rows($q) == 0) echo "<p style='grid-column: span 2; color: #888;'>Belum ada laporan kehilangan yang diverifikasi.</p>";
                    ?>
                </div>
            </div>
        </div>
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

    <button id="dark-toggle">🌙 Mode</button>
    
    <script>
    document.getElementById('formPostingHilang').addEventListener('submit', function(e) {
        e.preventDefault(); // Mencegah layar menjadi putih (pindah halaman)
        
        const formData = new FormData(this);
        const notif = document.getElementById('notifArea');

        fetch('backend/proses_laporan.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if(data.trim() === 'success') {
                // Notifikasi kapsul emas sesuai desain yang kamu suka
                notif.innerHTML = "<div class='notif-center success'>✨ Laporan berhasil dikirim! Menunggu verifikasi admin.</div>";
                this.reset(); // Kosongkan form
                
                // Opsional: Jika is_verified defaultnya 1 di database, 
                // bisa pakai location.reload() untuk langsung muncul di kanan.
                setTimeout(() => { location.reload(); }, 2000); 
            } else {
                notif.innerHTML = "<div class='notif-center error'>❌ Gagal mengirim laporan.</div>";
            }
            
            // Hilangkan notif setelah 3 detik
            setTimeout(() => { notif.innerHTML = ''; }, 3000);
        });
    });
    </script>
    
    <script src="script.js"></script>
</body>
</html>