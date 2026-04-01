<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['role'] != 'admin') {
    header("Location: dashboard_admin.php");
    exit();
}

$query_user = "SELECT * FROM tb_login ORDER BY id_user ASC";
$hasil_user = mysqli_query($koneksi, $query_user);

if (isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus']; 

    if ($id_hapus == $_SESSION['id_user']) {
        $notif = "Tidak bisa menghapus akun sendiri!";
    } else {
        mysqli_query($koneksi, "DELETE FROM tb_login WHERE id_user = $id_hapus");
        header("Location: dashboard_admin.php?notif=hapus");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <style>

    { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    body { display: flex; min-height: 100vh; background: linear-gradient(135deg, #E0E1DD, #F5F5F5); } /* Background Abu-abu dengan gradient */

    .sidebar {
        width: 250px;
        background: linear-gradient(180deg, #1B263B, #0D1321); /* Navy gradient */
        color: white;
        display: flex;
        flex-direction: column;
        position: fixed;
        height: 100%;
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        animation: slideIn 0.5s ease;
    }
    @keyframes slideIn {
        from { transform: translateX(-250px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .sidebar-header {
        padding: 20px;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        background: linear-gradient(135deg, #0D1321, #1B263B);
        border-bottom: 2px solid #2D6A4F;
    }
    .sidebar-menu { list-style: none; padding: 20px 0; }
    .sidebar-menu li { padding: 15px 25px; transition: all 0.3s ease; cursor: pointer; border-radius: 0 20px 20px 0; margin: 5px 10px; }
    .sidebar-menu li:hover { background: linear-gradient(90deg, #2D6A4F, #1B263B); transform: translateX(10px); }
    .sidebar-menu li a { color: white; text-decoration: none; display: block; width: 100%; }

    .main-content {
        margin-left: 250px; 
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .header {
        height: 70px;
        background: linear-gradient(90deg, #2D6A4F, #1B263B); /* Hijau ke Navy */
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 30px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .btn-logout {
        background-color: #1B263B;
        color: white;
        padding: 8px 20px;
        border-radius: 25px;
        text-decoration: none;
        font-weight: bold;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    .btn-logout:hover { background-color: #e74c3c; transform: scale(1.05); }

    .content-body { padding: 30px; background-color: #F8F9FA; min-height: calc(100vh - 70px); }
    .card {
        background-color: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        border-top: 5px solid #2D6A4F;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }
    .card:hover { transform: translateY(-5px); }
    h2, h3 { color: #1B263B; margin-bottom: 10px; }
    
    .notif {
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    .notif-sukses {
        background: linear-gradient(90deg, #d4edda, #c3e6cb);
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .notif-error {
        background: linear-gradient(90deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    table { width: 100%; border-collapse: collapse; margin-top: 20px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    th { background: linear-gradient(90deg, #1B263B, #2D6A4F); color: white; padding: 15px; text-align: left; font-weight: bold; }
    td { padding: 15px; border-bottom: 1px solid #eee; }
    tr { transition: all 0.3s ease; }
    tr:hover { background-color: #f1f8f4; transform: scale(1.01); }
    
    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        text-transform: uppercase;
    }
    .badge-admin {
        background: linear-gradient(90deg, #2D6A4F, #1B263B);
        color: white;
    }
    .badge-mahasiswa {
        background: linear-gradient(90deg, #1B263B, #2D6A4F);
        color: white;
    }
    
    .btn-hapus {
        background: linear-gradient(90deg, #e74c3c, #c0392b);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 12px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    .btn-hapus:hover {
        background: linear-gradient(90deg, #c0392b, #e74c3c);
        transform: scale(1.05);
    }
</style>

<div class="sidebar">
    <div class="sidebar-header">
        Dashboard <span>Santri</span>
    </div>
    <ul class="sidebar-menu">
        <li><a href="dashboard_admin.php">🏠 Dashboard</a></li>
        <?php if ($_SESSION['role'] == 'admin') : ?>
        <?php endif; ?>
    </ul>
</div>

<div class="main-content">
    <div class="header">
        <div class="breadcrumb">Panel / <strong>Dashboard</strong></div>
        <div class="user-info">
            <span style="margin-right: 15px;">Halo, <strong><?= $_SESSION['username'] ?></strong></span>
            <a href="logout.php" class="btn-logout">Logout</a>
        </div>
    </div>

    <div class="content-body">
        <div class="card">
            <h2>Selamat Datang</h2>
            <p>Anda login sebagai: <strong style="color: #2D6A4F;"><?= strtoupper($_SESSION['role']) ?></strong></p>
            <hr style="margin: 20px 0; border: 0; border-top: 1px solid #eee;">
            
            <p>Silahkan pilih menu di samping untuk mengelola data sistem.</p>
        </div>

        <!-- Notifikasi -->
        <?php if (isset($_GET['notif']) && $_GET['notif'] == 'hapus') : ?>
            <div class="notif notif-sukses">✅ User berhasil dihapus.</div>
        <?php endif; ?>
        <?php if (isset($notif)) : ?>
            <div class="notif notif-error">⚠️ <?= $notif ?></div>
        <?php endif; ?>

        <div class="card">
            <h3>📋 Daftar Semua Pengguna</h3>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID User</th>
                        <th>Username</th>
                        <th>Password (MD5)</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($hasil_user)) :
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['id_user'] ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td style="font-size:11px; color:#7f8c8d;">
                            <?= substr($row['password'], 0, 20) ?>...
                        </td>
                        <td>
                            <span class="badge badge-<?= $row['role'] ?>">
                                <?= ucfirst($row['role']) ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($row['id_user'] != $_SESSION['id_user']) : ?>
                                <a href="?hapus=<?= $row['id_user'] ?>" 
                                   class="btn-hapus"
                                   onclick="return confirm('Yakin ingin menghapus user <?= $row['username'] ?>?')">
                                    Hapus
                                </a>
                            <?php else : ?>
                                <span style="color:#bdc3c7; font-size:12px;">(Anda)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>