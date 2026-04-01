<?php
session_start();
include "koneksi.php";

// Proteksi login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Contoh data mapel untuk guru (bisa dari database nanti)
$mapel = "Bahasa Indonesia";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* RESET & DASAR */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(120deg, #1e8449, #145a32);
            min-height: 100vh;
        }

        /* NAVBAR (untuk Guru) */
        .navbar {
            background: rgba(255,255,255,0.1);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
        }

        .btn-logout {
            background: #e74c3c;
            padding: 8px 15px;
            border-radius: 20px;
            color: white;
            text-decoration: none;
        }

        /* SIDEBAR (untuk Mahasiswa) */
        .sidebar {
            width: 280px;
            background: rgba(27, 38, 59, 0.9);
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

        @keyframes glow {
            from { box-shadow: 0 0 10px #2D6A4F; }
            to { box-shadow: 0 0 20px #2D6A4F; }
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-menu li {
            padding: 18px 30px;
            transition: all 0.4s ease;
            cursor: pointer;
            border-radius: 0 25px 25px 0;
            margin: 8px 15px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-menu li::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(45, 106, 79, 0.5), transparent);
            transition: left 0.5s;
        }

        .sidebar-menu li:hover::before {
            left: 100%;
        }

        .sidebar-menu li:hover {
            background: rgba(45, 106, 79, 0.3);
            transform: translateX(15px) scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .sidebar-menu li a {
            color: white;
            text-decoration: none;
            display: block;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        /* MAIN CONTENT AREA (untuk Mahasiswa) */
        .main-content {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* HEADER (untuk Mahasiswa) */
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

        .header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #2D6A4F, #FFFFFF, #2D6A4F);
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* CONTAINER (untuk Guru) */
        .container {
            max-width: 1100px;
            margin: 40px auto;
        }

        /* CARD */
        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* WELCOME */
        .welcome {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            text-align: center;
        }

        /* GRID */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        /* STAT */
        .stat {
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            color: white;
        }

        .bg1 { background: #27ae60; }
        .bg2 { background: #7f8c8d; }
        .bg3 { background: #95a5a6; }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        th {
            background: linear-gradient(90deg, #1B263B, #2D6A4F);
            color: white;
            padding: 18px;
            text-align: left;
            font-weight: bold;
        }

        td {
            padding: 18px;
            border-bottom: 1px solid rgba(238, 238, 238, 0.5);
        }

        tr {
            transition: all 0.3s ease;
            position: relative;
        }

        tr::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(45, 106, 79, 0.1) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        tr:hover::after {
            opacity: 1;
        }

        tr:hover {
            background-color: rgba(241, 248, 244, 0.8);
            transform: scale(1.01);
        }

        /* BADGE */
        .badge {
            background: #27ae60;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
        }

        /* MAPEL BOX */
        .mapel-box {
            background: #eafaf1;
            border-left: 5px solid #27ae60;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            color: #145a32;
            font-weight: 500;
        }

        /* CONTENT BODY (untuk Mahasiswa) */
        .content-body {
            padding: 40px;
            background: rgba(248, 249, 250, 0.8);
            min-height: calc(100vh - 80px);
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }

        h2, h3 {
            color: #1B263B;
            margin-bottom: 15px;
        }

        /* List Akses */
        .kartu-akses ul {
            padding-left: 20px;
            color: #34495e;
            font-size: 15px;
            line-height: 1.8;
        }

        .kartu-akses li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <?php if ($_SESSION['role'] == 'guru'): ?>
        <!-- Layout untuk Guru -->
        <div class="navbar">
            <h3>📚 Dashboard Guru</h3>
            <div>
                <?= $_SESSION['username']; ?> |
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>

        <div class="sidebar">
            <div class="sidebar-header">
                dashboard <span>Santri</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="dashboard_awal.php">🏠 Dashboard</a></li>
                <li><a href="profil_saya.php">👤 Profil Saya</a></li>
                <li><a href="akademik.php">📚 Akademik</a></li>
                <li><a href="pengaturan.php">⚙️ Pengaturan</a></li>
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <div class="breadcrumb">Panel / <strong>Dashboard Guru</strong></div>
                <div class="user-info">
                    <span style="margin-right: 15px;">Halo, <strong><?= $_SESSION['username'] ?></strong></span>
                </div>
            </div>

            <div class="content-body">
                <!-- WELCOME -->
                <div class="card welcome">
                    <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['username']); ?> 👋</h2>
                    <p>Anda login sebagai Guru</p>
                </div>

                <!-- STAT -->
                <div class="grid">
                    <div class="stat bg1">
                        <h2>30</h2>
                        <p>Jumlah Santri</p>
                    </div>
                    <div class="stat bg2">
                        <h2>5</h2>
                        <p>Kelas Diampu</p>
                    </div>
                    <div class="stat bg3">
                        <h2>12</h2>
                        <p>Mata Pelajaran</p>
                    </div>
                </div>

                <!-- INFO AKUN -->
                <div class="card">
                    <h3>📄 Informasi Akun</h3>
                    <table>
                        <tr>
                            <td>ID User</td>
                            <td><?= $_SESSION['id_user']; ?></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td><?= htmlspecialchars($_SESSION['username']); ?></td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td><span class="badge">Guru</span></td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>Aktif</td>
                        </tr>
                        <tr>
                            <td>Mengajar</td>
                            <td><?= $mapel; ?></td>
                        </tr>
                    </table>
                </div>

                <div class="card kartu-akses" style="--i: 3;">
                    <h3>⚠️ Hak Akses Guru</h3>
                    <ul>
                        <li>✅ Dapat login ke sistem</li>
                        <li>✅ Dapat melihat data santri</li>
                        <li>✅ Dapat mengelola akademik</li>
                        <li>❌ Tidak dapat menghapus akun admin</li>
                        <li>❌ Tidak dapat mengakses halaman mahasiswa tertentu</li>
                    </ul>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Layout untuk Mahasiswa -->
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
    <?php endif; ?>
</body>
</html>