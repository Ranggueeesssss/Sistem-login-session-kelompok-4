<?php
session_start();
include "koneksi.php";

// Proteksi login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Proteksi role guru
if ($_SESSION['role'] != 'guru') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akademik</title>
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

        /* CARD */
        .card {
            background: #ffffff;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 40px rgba(0,0,0,0.2);
        }

        h2, h3 {
            color: #1B263B;
            margin-bottom: 15px;
        }

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
    </style>
</head>
<body>
    <!-- Layout untuk Guru -->
    <div class="navbar">
        <h3>📚 Akademik</h3>
        <div>
            <?= $_SESSION['username']; ?> |
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>

    <div class="sidebar">
        <div class="sidebar-header">
            Dashboard <span>Santri</span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard_guru.php">🏠 Dashboard</a></li>
            <li><a href="profil_saya.php">👤 Profil Saya</a></li>
            <li><a href="akademik.php">📚 Akademik</a></li>
            <li><a href="pengaturan.php">⚙️ Pengaturan</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div class="breadcrumb">Panel / <strong>Akademik</strong></div>
            <div class="user-info">
                <span style="margin-right: 15px;">Halo, <strong><?= $_SESSION['username'] ?></strong></span>
            </div>
        </div>

        <div class="content-body">
            <div class="card">
                <h3>📚 Data Akademik</h3>
                <p>Contoh data nilai / jadwal. Sesuaikan dengan tabel dan kebutuhan Anda.</p>
                <table>
                    <thead>
                        <tr><th>No</th><th>Mata Kuliah</th><th>SKS</th><th>Nilai</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>1</td><td>Matematika Komputasional</td><td>3</td><td>A</td><td>Lulus</td></tr>
                        <tr><td>2</td><td>Algoritma & Pemrograman</td><td>4</td><td>B+</td><td>Lulus</td></tr>
                        <tr><td>3</td><td>Basis Data</td><td>3</td><td>A-</td><td>Lulus</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>