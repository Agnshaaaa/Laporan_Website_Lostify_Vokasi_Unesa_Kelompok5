<?php include "config.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Barang Temu - Lostify</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Mengikuti Style Banner Hitam di Barang Hilang */
        .welcome-banner {
            background: #121212 !important; 
            border-radius: 20px;
            padding: 50px;
            color: #ffffff;
            margin: 30px 0 40px 0;
            border-left: 10px solid #FFD700; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .welcome-banner h1 span {
            color: #FFD700;
        }
        .btn-konfirmasi {
            display: block;
            background: #FF4747;
            color: white;
            text-align: center;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 12px;
            margin-top: 10px;
            border: none;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body class="<?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? 'dark' : ''; ?>">
    <div id="notifArea"></div>

    <header class="navbar">
        <div class="logo">LOSTIFY</div>
        <nav class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="barang_hilang.php">Barang Hilang</a>
            <a href="barang_temu.php" class="active">Barang Temu</a>
            <a href="admin_panel.php" style="color: #FF4444; font-weight: bold;">⚠️ Admin</a>
        </nav>
    </header>

    <main style="padding: 20px 50px;">
        <div class="welcome-banner">
            <h1>Temuan <span>Barang!</span></h1>
            <p>Apresiasi setinggi-tingginya untuk kejujuran Anda. Mari kembalikan ke pemiliknya.</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px;">
            <div class="stat-card" style="text-align: left; padding: 30px; border-bottom: 5px solid var(--hitam);">
                <h3>🤝 Laporkan Temuan</h3>
                <form id="formPostingTemu" enctype="multipart/form-data">
                    <input type="hidden" name="tipe" value="temu">
                    <input type="text" name="nama_barang" placeholder="Nama Barang yang Ditemukan" required>
                    <input type="text" name="lokasi" placeholder="Ditemukan di Mana? (Contoh: Lab Komputer)" required>
                    <input type="date" name="tanggal" required>
                    <textarea name="deskripsi" placeholder="Deskripsikan kondisi barang saat ditemukan..." style="height: 80px;"></textarea>
                    
                    <div style="background: #f1f1f1; padding: 10px; border-radius: 8px; margin: 10px 0;">
                        <label style="font-size: 12px; font-weight: bold;">📸 Foto Barang Temuan:</label>
                        <input type="file" name="foto" accept="image/*" required>
                    </div>
                    
                    <input type="text" name="kontak" placeholder="WhatsApp Anda (Penemu)" required>
                    <button type="submit" style="background: var(--hitam); color: var(--kuning); width: 100%; padding: 12px; border-radius: 8px; font-weight: bold; cursor: pointer; border: none;">
                        Posting Temuan
                    </button>
                </form>
            </div>

            <div class="stat-card">
                <h3>📍 Inventaris Barang Temuan</h3>
                <div id="listBarangTemu" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-top: 15px; width: 100%;">
                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM laporan_barang WHERE tipe_laporan='temu' AND is_verified=1 ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($q)) {
                        $fotoPath = !empty($row['foto']) ? "uploads/" . $row['foto'] : "assets/placeholder.png";
                        echo "<div class='item-card' style='background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border: 1px solid #eee;'>";
                        echo "<img src='$fotoPath' style='width: 100%; height: 150px; object-fit: cover;'>";
                        echo "<div style='padding: 15px; text-align: left;'>";
                        echo "<h4 style='margin: 0; color: var(--hitam);'>{$row['nama_barang']}</h4>";
                        echo "<p style='font-size: 11px; color: #666; margin: 5px 0;'>📍 {$row['lokasi']} | 📅 {$row['tanggal']}</p>";
                        echo "<p style='font-size: 13px; color: #333; height: 40px; overflow: hidden;'>{$row['deskripsi']}</p>";
                        
                        $waLink = "https://wa.me/" . preg_replace('/[^0-9]/', '', $row['kontak_pelapor']);
                        echo "<a href='$waLink' target='_blank' style='display: block; background: #25D366; color: white; text-align: center; padding: 10px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 12px; margin-top: 10px;'>📞 Hubungi Penemu</a>";
                        
                        // Tombol Konfirmasi Penerimaan (Shopee Style)
                        echo "<button onclick='konfirmasiTerima({$row['id']}, \"{$row['nama_barang']}\")' class='btn-konfirmasi'>📦 Pesanan Diterima</button>";
                        echo "</div></div>";
                    }
                    if(mysqli_num_rows($q) == 0) echo "<p style='grid-column: span 2; color: #888;'>Belum ada inventaris barang temuan.</p>";
                    ?>
                </div>
            </div>
        </div>
    </main>

    <script>
    // Fungsi Konfirmasi Penghapusan Otomatis
    function konfirmasiTerima(id, nama) {
        if (confirm("Konfirmasi bahwa barang '" + nama + "' sudah kembali ke tangan Anda? Data akan dihapus otomatis.")) {
            fetch('backend/konfirmasi_kembali.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id=' + id + '&nama=' + encodeURIComponent(nama)
            })
            .then(response => response.text())
            .then(data => {
                if(data.trim() === 'success') {
                    document.getElementById('notifArea').innerHTML = "<div class='notif-center success'>✨ Alhamdulillah! Barang telah kembali ke pemilik.</div>";
                    setTimeout(() => { location.reload(); }, 2000);
                }
            });
        }
    }

    document.getElementById('formPostingTemu').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const notif = document.getElementById('notifArea');

        fetch('backend/proses_laporan.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if(data.trim() === 'success') {
                notif.innerHTML = "<div class='notif-center success'>✨ Temuan Berhasil Dilaporkan! Menunggu verifikasi.</div>";
                this.reset();
                setTimeout(() => { location.reload(); }, 2000);
            } else {
                notif.innerHTML = "<div class='notif-center error'>❌ Gagal mengirim laporan.</div>";
            }
            setTimeout(() => { notif.innerHTML = ''; }, 3000);
        });
    });
    </script>
    <script src="script.js"></script>
</body>
</html>