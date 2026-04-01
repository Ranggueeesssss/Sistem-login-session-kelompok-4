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
    header("Location: dashboardadmin.php");
    exit();
}

// Contoh data mapel (bisa dari database nanti)
$mapel = "Bahasa Indonesia";
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Guru</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
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

/* NAVBAR */
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

/* CONTAINER */
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
}

td {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

td:first-child {
    font-weight: bold;
    color: #555;
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

</style>
</head>

<body>

<div class="navbar">
    <h3>📚 Dashboard Guru</h3>
    <div>
        <?= $_SESSION['username']; ?> |
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</div>

<div class="container">

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
        </table>

    </div>

</div>

</body>
</html>