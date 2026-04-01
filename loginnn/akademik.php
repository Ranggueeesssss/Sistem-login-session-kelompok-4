<?php
session_start();
include "koneksi.php";
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
if ($_SESSION['role'] != 'mahasiswa') { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Akademik</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --navy: #1B263B; --green: #2D6A4F; --gray: #E0E1DD; }
        *{margin:0;padding:0;box-sizing:border-box;}
        body{font-family:'Poppins',sans-serif; background:linear-gradient(135deg,#1B263B,#415A77,#E0E1DD); min-height:100vh;}
        .layout{display:flex;}
        .sidebar{width:250px;position:fixed;height:100%;background:rgba(27,38,59,.93);padding-top:20px;border-right:1px solid rgba(45,106,79,.4);}
        .sidebar-header{color:#fff;text-align:center;font-size:22px;font-weight:700;margin-bottom:20px;padding:12px;background:linear-gradient(90deg,rgba(45,106,79,.9),rgba(27,38,59,.95));border-radius:12px;margin:0 12px;}
        .sidebar-menu{list-style:none;}
        .sidebar-menu li a{display:block;color:#dbe9f3;padding:11px 18px;text-decoration:none;transition:.3s;}
        .sidebar-menu li a:hover{background:rgba(45,106,79,.35);padding-left:24px;}
        .main{margin-left:250px;padding:22px 30px;}
        .header{background:linear-gradient(90deg,#2D6A4F,#1B263B);border-radius:16px;padding:14px 20px;color:#fff;display:flex;justify-content:space-between;align-items:center;box-shadow:0 8px 22px rgba(0,0,0,.2);}
        .card{background:rgba(255,255,255,.95);border-radius:16px;padding:24px;margin-top:18px;box-shadow:0 10px 26px rgba(0,0,0,.16);}
        .title{font-size:22px;color:#1B263B;margin-bottom:12px;}
        table{width:100%;border-collapse:collapse}
        th,td{padding:12px;border-bottom:1px solid #e5ecf2}
        th{background:linear-gradient(90deg,#1B263B,#2D6A4F);color:#fff;text-align:left;}
    </style>
</head>
<body>
    <div class="layout">
        <div class="sidebar">
            <div class="sidebar-header">POLIJE SYSTEM</div>
            <ul class="sidebar-menu">
                <li><a href="dashboard_mahasiswa.php">🏠 Dashboard</a></li>
                <li><a href="profil_saya.php">👤 Profil Saya</a></li>
                <li><a href="akademik.php">📚 Akademik</a></li>
                <li><a href="pengaturan.php">⚙️ Pengaturan</a></li>
            </ul>
        </div>
        <div class="main">
            <div class="header">
                <div>Panel / Akademik</div>
                <div><strong><?= htmlspecialchars($_SESSION['username']) ?></strong> | <a href="logout.php" style="color:white;text-decoration:none;background:#2D6A4F;padding:5px 12px;border-radius:14px;">Logout</a></div>
            </div>
            <div class="card">
                <div class="title">Data Akademik</div>
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