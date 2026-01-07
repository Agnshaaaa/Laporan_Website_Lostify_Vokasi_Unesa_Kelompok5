<?php
session_start();
include "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];

// Ambil data lengkap user dari database
$query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya - LOSTIFY</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-top: 10px solid var(--kuning);
        }
        .profile-header { text-align: center; margin-bottom: 30px; }
        .form-group { margin-bottom: 15px; text-align: left; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .btn-logout {
            background: #ff4444; color: white; border: none; padding: 10px 20px;
            border-radius: 8px; cursor: pointer; width: 100%; font-weight: bold; margin-top: 20px;
        }
    </style>
</head>
<body class="<?php echo isset($_COOKIE['theme']) && $_COOKIE['theme'] == 'dark' ? 'dark' : ''; ?>">
    
    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="notif-center success">✨ Profil Berhasil Diperbarui!</div>
    <?php elseif(isset($_GET['status']) && $_GET['status'] == 'error'): ?>
        <div class="notif-center error">❌ Gagal memperbarui data.</div>
    <?php endif; ?>
            
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.pathname);
        }

        setTimeout(() => {
            const notif = document.querySelector('.notif-center');
            if(notif) {
                notif.style.opacity = '0';
                setTimeout(() => { notif.style.display = 'none'; }, 500);
            }
        }, 3000);
    </script>

    <header class="navbar">
        <div class="logo">LOSTIFY</div>
        <nav class="nav-links">
            <a href="index.php">Dashboard</a>
            <a href="barang_hilang.php">Barang Hilang</a>
            <a href="barang_temu.php">Barang Temu</a>
        </nav>
    </header>

    <main class="profile-container">
        <div class="profile-header">
            <h2>Data Profil <span><?php echo htmlspecialchars($username); ?></span></h2>
            <p>Kelola informasi pribadi dan keamanan akun Anda.</p>
        </div>

        <form action="backend/update_profile.php" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>
            </div>
            <div class="form-group">
                <label>Email Aktif</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label>Password Baru (Kosongkan jika tidak ingin ganti)</label>
                <input type="password" name="new_password">
            </div>
            
            <button type="submit">Simpan Perubahan</button>
        </form>

        <hr style="margin: 25px 0; border: 0; border-top: 1px solid #eee;">
            
        <form action="backend/logout.php" method="POST">
            <button type="submit" style="background: #db0000ff; color: white;" class="btn-logout">Logout</button>
        </form>
    </main>

    <script>
        // Menghilangkan notif otomatis setelah 3 detik
        setTimeout(() => {
            const notif = document.querySelector('.notif-center');
            if(notif) {
                notif.style.opacity = '0';
                setTimeout(() => { notif.style.display = 'none'; }, 500);
            }
        }, 3000);
    </script>
    <script src="script.js"></script>
</body>
</html>