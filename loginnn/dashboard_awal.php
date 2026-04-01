<?php
session_start();
include "koneksi2.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --navy: #1B263B;
            --navy-l: #415A77;
            --green: #2D6A4F;
            --gray: #E0E1DD;
            --white: #FFFFFF;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--navy), var(--navy-l), var(--gray));
            color: #263238;
            min-height: 100vh;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="%23FFFFFF" opacity="0.08"/></svg>') repeat;
            opacity: 0.30;
            z-index: -1;
            animation: drift 20s linear infinite;
        }
        @keyframes drift { from { transform: translateY(0); } to { transform: translateY(-90px); } }
        .sidebar {
            width: 250px;
            position: fixed;
            inset: 0 auto auto 0;
            height: 100vh;
            background: rgba(27,38,59,0.93);
            backdrop-filter: blur(12px);
            border-right: 1px solid rgba(45,106,79,0.35);
            box-shadow: 3px 0 20px rgba(0,0,0,0.25);
            padding-top: 20px;
        }
        .sidebar-header {
            color: white;
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 20px;
            padding: 12px;
            background: linear-gradient(90deg, rgba(45,106,79,0.9), rgba(27,38,59,0.95));
            border-radius: 12px;
            margin: 0 12px 15px;
        }
        .sidebar-menu { list-style: none; }
        .sidebar-menu li {
            margin: 6px 10px;
            border-radius: 0 20px 20px 0;
            overflow: hidden;
        }
        .sidebar-menu li a {
            display: block;
            text-decoration: none;
            color: #dbe9f3;
            padding: 12px 18px;
            font-weight: 600;
            transition: 0.3s;
        }
        .sidebar-menu li a:hover {
            background: linear-gradient(90deg, rgba(45,106,79,0.55), rgba(27,38,59,0.8));
            color: #fff;
            padding-left: 24px;
        }
        .main-content {
            margin-left: 250px;
            padding: 22px 32px 30px;
            min-height: 100vh;
        }
        .header {
            background: linear-gradient(90deg, rgba(45,106,79,0.9), rgba(27,38,59,0.8));
            border-radius: 16px;
            color: #fff;
            padding: 14px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 8px 22px rgba(0,0,0,0.2);
            margin-bottom: 24px;
        }
        .header .user {
            font-size: 14px;
            opacity: 0.92;
        }
        .btn-logout {
            background: #2D6A4F;
            color: white;
            border: 0;
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 600;
            cursor: pointer;
            transition: .3s;
            text-decoration: none;
        }
        .btn-logout:hover { transform: scale(1.04); background: #1c4d36; }
        .content-body { display: grid; gap: 20px; }
        .card {
            background: rgba(255,255,255,0.92);
            border: 1px solid rgba(45,106,79,0.2);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 12px 28px rgba(0,0,0,0.12);
        }
        .title { font-size: 24px; font-weight: 700; color: #1B263B; margin-bottom: 8px; }
        .subtitle { color: #2D6A4F; font-weight: 600; margin-bottom: 14px; }
        .badge { display:inline-block; padding: 5px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; color: white; background: linear-gradient(90deg,#2D6A4F,#1B263B); }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #edf1f3; }
        th { background: linear-gradient(90deg, #1B263B, #2D6A4F); color: #fff; text-align: left; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">POLIJE SYSTEM</div>
        <ul class="sidebar-menu">
            <li><a href="dashboard_awal.php">🏠 Dashboard</a></li>
            <li><a href="profil_saya.php">👤 Profil Saya</a></li>
            <li><a href="akademik.php">📚 Akademik</a></li>
            <li><a href="setting.php">⚙️ Settings</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div>Panel / Dashboard Mahasiswa</div>
            <div class="user">Halo, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> | <a href="logout.php" class="btn-logout">Logout</a></div>
        </div>

        <div class="content-body">
            <div class="card">
                <div class="title">Selamat Datang, <?= htmlspecialchars($_SESSION['username']) ?>!</div>
                <div class="subtitle">Akses cepat untuk fitur akademik dan pengelolaan profil.</div>
                <p>Anda login sebagai <strong>Mahasiswa</strong>. Silakan gunakan menu di kiri untuk memilih modul.</p>
            </div>

            <div class="card">
                <div class="title">Info Akun</div>
                <table>
                    <tr><th>ID User</th><td><?= htmlspecialchars($_SESSION['id_user']) ?></td></tr>
                    <tr><th>Username</th><td><?= htmlspecialchars($_SESSION['username']) ?></td></tr>
                    <tr><th>Role</th><td><span class="badge">Mahasiswa</span></td></tr>
                    <tr><th>Status</th><td>Aktif</td></tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>