<?php

// =============================================
// FILE: dashboard_mahasiswa.php
// Fungsi: Halaman khusus untuk role MAHASISWA
// =============================================

session_start();
include "koneksi.php";

// ---- PROTEKSI HALAMAN ----
// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Cek apakah role-nya mahasiswa
// Kalau bukan mahasiswa, arahkan ke dashboard admin
if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: dashboard_mahasiswa.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa</title>
    <style>
    /* 1. RESET & DASAR */
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body { display: flex; min-height: 100vh; background: linear-gradient(135deg, #E0E1DD, #F5F5F5); position: relative; overflow-x: hidden; }
    body::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="%23FFFFFF" opacity="0.1"/></svg>') repeat; z-index: -1; animation: parallax 20s linear infinite; }
    @keyframes parallax { 0% { transform: translateY(0); } 100% { transform: translateY(-100px); } }

    /* 2. SIDEBAR (GLASSMORPHISM NAVY) */
    .sidebar {
        width: 280px;
        background: rgba(27, 38, 59, 0.9); /* Navy transparan */
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        color: white;
        display: flex;
        flex-direction: column;
        position: fixed;
        height: 100%;
        box-shadow: 5px 0 20px rgba(0,0,0,0.2);
        border-right: 1px solid rgba(45, 106, 79, 0.3);
        animation: slideIn 0.6s ease-out;
    }
    @keyframes slideIn {
        from { transform: translateX(-280px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .sidebar-header {
        padding: 25px;
        font-size: 22px;
        font-weight: bold;
        text-align: center;
        background: linear-gradient(135deg, rgba(13, 19, 33, 0.8), rgba(27, 38, 59, 0.8));
        border-bottom: 2px solid #2D6A4F;
        animation: glow 2s ease-in-out infinite alternate;
    }
    @keyframes glow { from { box-shadow: 0 0 10px #2D6A4F; } to { box-shadow: 0 0 20px #2D6A4F; } }
    .sidebar-menu { list-style: none; padding: 20px 0; }
    .sidebar-menu li { padding: 18px 30px; transition: all 0.4s ease; cursor: pointer; border-radius: 0 25px 25px 0; margin: 8px 15px; position: relative; overflow: hidden; }
    .sidebar-menu li::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(45, 106, 79, 0.5), transparent); transition: left 0.5s; }
    .sidebar-menu li:hover::before { left: 100%; }
    .sidebar-menu li:hover { background: rgba(45, 106, 79, 0.3); transform: translateX(15px) scale(1.05); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
    .sidebar-menu li a { color: white; text-decoration: none; display: block; width: 100%; position: relative; z-index: 1; }

    /* 3. MAIN CONTENT AREA */
    .main-content {
        margin-left: 280px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    /* 4. HEADER (HIJAU EMERALD DENGAN GLOW) */
    .header {
        height: 80px;
        background: linear-gradient(90deg, #2D6A4F, #1B263B);
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 40px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        position: relative;
    }
    .header::after { content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 3px; background: linear-gradient(90deg, #2D6A4F, #FFFFFF, #2D6A4F); animation: shimmer 3s linear infinite; }
    @keyframes shimmer { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }
    .btn-logout {
        background: linear-gradient(45deg, #1B263B, #2D6A4F);
        color: white;
        padding: 10px 25px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: bold;
        font-size: 14px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .btn-logout:hover { transform: scale(1.1) rotate(2deg); box-shadow: 0 6px 15px rgba(0,0,0,0.3); }

    /* 5. CONTENT BODY */
    .content-body { padding: 40px; background: rgba(248, 249, 250, 0.8); min-height: calc(100vh - 80px); display: grid; grid-template-columns: 1fr; gap: 30px; animation: fadeInUp 0.8s ease-out; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        border: 1px solid rgba(45, 106, 79, 0.2);
        margin-bottom: 0;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        animation: stagger 0.6s ease-out forwards; animation-delay: calc(var(--i) * 0.1s); opacity: 0;
    }
    @keyframes stagger { to { opacity: 1; transform: translateY(0); } }
    .card:hover { transform: translateY(-10px) scale(1.02); box-shadow: 0 15px 40px rgba(0,0,0,0.2); }
    h2, h3 { color: #1B263B; margin-bottom: 15px; }
    
    /* Badge */
    .badge {
        padding: 6px 12px;
        border-radius: 25px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        background: linear-gradient(90deg, #2D6A4F, #1B263B);
        color: white;
    }
    
    /* Tabel Styling */
    table { width: 100%; border-collapse: collapse; margin-top: 25px; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    th { background: linear-gradient(90deg, #1B263B, #2D6A4F); color: white; padding: 18px; text-align: left; font-weight: bold; }
    td { padding: 18px; border-bottom: 1px solid rgba(238, 238, 238, 0.5); }
    tr { transition: all 0.3s ease; position: relative; }
    tr::after { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle, rgba(45, 106, 79, 0.1) 0%, transparent 70%); opacity: 0; transition: opacity 0.3s; }
    tr:hover::after { opacity: 1; }
    tr:hover { background-color: rgba(241, 248, 244, 0.8); transform: scale(1.01); }
    
    /* List Akses */
    .kartu-akses ul { padding-left: 20px; color: #34495e; font-size: 15px; line-height: 1.8; }
    .kartu-akses li { margin-bottom: 5px; }
</style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">
        POLIJE <span>SYSTEM</span>
    </div>
    <ul class="sidebar-menu">
       <li><a href="dashboard_awal.php">🏠 Dashboard</a></li>
      <li><a href="profilsaya.php">👤 Profil Saya</a></li>
      <li><a href="akademik.php">📚 Akademik</a></li>
      <li><a href="pengaturan.php">⚙️ Pengaturan</a></li>
    </ul>
</div>

<div class="main-content">
    <div class="header">
        <div class="breadcrumb">Panel / <strong>Dashboard Mahasiswa</strong></div>
        <div class="user-info">
            <span style="margin-right: 15px;">Halo, <strong><?= $_SESSION['username'] ?></strong></span>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>

    <div class="content-body">
        <div class="card" style="--i: 1;">
            <div class="icon" style="font-size: 50px; margin-bottom: 15px;">🎓</div>
            <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
            <p>Anda berhasil login sebagai <strong>Mahasiswa</strong>.</p>
        </div>

        <div class="card" style="--i: 2;">
            <h3>📄 Informasi Akun Anda</h3>
            <table>
                <tr>
                    <th>ID User</th>
                    <td><?= $_SESSION['id_user'] ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?= htmlspecialchars($_SESSION['username']) ?></td>
                </tr>
                <tr>
                    <th>Role / Hak Akses</th>
                    <td><span class="badge">Mahasiswa</span></td>
                </tr>
                <tr>
                    <th>Status Login</th>
                    <td>✅ Aktif</td>
                </tr>
            </table>
        </div>

        <div class="card kartu-akses" style="--i: 3;">
            <h3>⚠️ Hak Akses Mahasiswa</h3>
            <ul>
                <li>✅ Dapat login ke sistem</li>
                <li>✅ Dapat melihat data profil sendiri</li>
                <li>❌ Tidak dapat melihat data user lain</li>
                <li>❌ Tidak dapat menghapus atau mengelola akun</li>
                <li>❌ Tidak dapat mengakses halaman Admin</li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>