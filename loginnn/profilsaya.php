<?php
session_start();
include "koneksi.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
if ($_SESSION['role'] != 'mahasiswa') {
    header("Location: login.php");
    exit();
}

$id = (int) $_SESSION['id_user'];
$q = mysqli_query($koneksi, "SELECT * FROM tb_login WHERE id_user = $id");
$user = mysqli_fetch_assoc($q);
if (!$user) {
    echo "Data user tidak ditemukan.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Profil Saya</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins', sans-serif; }
body { background: linear-gradient(135deg,#1B263B,#415A77,#E0E1DD); min-height:100vh; }
.layout{ display:flex; }
.sidebar { width:250px; position:fixed; height:100vh; background:rgba(27,38,59,0.95); padding-top:20px; }
.sidebar-header { color:#fff; text-align:center; font-weight:700; padding:15px; border-bottom:1px solid rgba(255,255,255,0.12);}
.sidebar-menu { list-style:none; margin-top:20px; }
.sidebar-menu li a { display:block; text-decoration:none; color:#dbe9f3; padding:10px 18px; transition:.2s; }
.sidebar-menu li a:hover { background:rgba(45,106,79,0.35); color:#fff; padding-left:24px; }
.main { margin-left:250px; padding:24px; }
.header { background:linear-gradient(90deg,#2D6A4F,#1B263B); color:#fff; border-radius:14px; padding:14px 18px; display:flex; justify-content:space-between; align-items:center; box-shadow:0 8px 20px rgba(0,0,0,.2); }
.card { background:#fff; border-radius:14px; padding:22px; margin-top:20px; box-shadow:0 10px 24px rgba(0,0,0,.15); }
.card h2 { margin-bottom:12px; color:#1B263B; }
</style>
</head>
<body>
<div class="layout">
  <div class="sidebar">
    <div class="sidebar-header">POLIJE SYSTEM</div>
    <ul class="sidebar-menu">
      <li><a href="dashboard_mahasiswa.php">🏠 Dashboard</a></li>
      <li><a href="profilsaya.php">👤 Profil Saya</a></li>
      <li><a href="akademik.php">📚 Akademik</a></li>
      <li><a href="pengaturan.php">⚙️ Pengaturan</a></li>
    </ul>
  </div>
  <div class="main">
    <div class="header">
      <div>Panel / Profil Saya</div>
      <div><strong><?= htmlspecialchars($_SESSION['username']) ?></strong> | <a href="logout.php" style="color:#fff;text-decoration:none;background:#2D6A4F;padding:6px 12px;border-radius:12px;">Logout</a></div>
    </div>
    <div class="card">
      <h2>Profil Saya</h2>
      <p><strong>ID:</strong> <?= htmlspecialchars($user['id_user']) ?></p>
      <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
      <p><strong>Role:</strong> <?= htmlspecialchars($user['role']) ?></p>
    </div>
  </div>
</div>
</body>
</html>