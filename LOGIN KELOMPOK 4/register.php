<?php
// =============================================
// FILE: register.php
// Fungsi: Halaman pendaftaran akun baru
// =============================================

session_start();
include "koneksi.php";

$pesan       = "";
$jenis_pesan = ""; // "sukses" atau "error"

// ---- PROSES REGISTER ----
if (isset($_POST['btn_register'])) {

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $konfirm  = trim($_POST['konfirmasi']);
    $role     = $_POST['role'];  // 'admin' atau 'mahasiswa'

    // --- Validasi ---
    if (empty($username) || empty($password) || empty($konfirm)) {
        $pesan       = "Semua field wajib diisi!";
        $jenis_pesan = "error";

    } elseif (strlen($username) < 4) {
        $pesan       = "Username minimal 4 karakter!";
        $jenis_pesan = "error";

    } elseif (strlen($password) < 6) {
        $pesan       = "Password minimal 6 karakter!";
        $jenis_pesan = "error";

    } elseif ($password !== $konfirm) {
        $pesan       = "Password dan konfirmasi password tidak cocok!";
        $jenis_pesan = "error";

    } else {
        // Cek apakah username sudah dipakai
        $cek   = mysqli_query($koneksi, "SELECT * FROM tb_login WHERE username = '$username'");
        $exist = mysqli_num_rows($cek);

        if ($exist > 0) {
            $pesan       = "Username '$username' sudah digunakan. Pilih username lain!";
            $jenis_pesan = "error";
        } else {
            // Simpan ke database
            // Password di-hash dengan MD5 (sama dengan saat login)
            $password_hash = MD5($password);

            $query  = "INSERT INTO tb_login (username, password, role) 
                       VALUES ('$username', '$password_hash', '$role')";
            $simpan = mysqli_query($koneksi, $query);

            if ($simpan) {
                $pesan       = "Akun berhasil dibuat! Silakan login.";
                $jenis_pesan = "sukses";
            } else {
                $pesan       = "Gagal menyimpan data: " . mysqli_error($koneksi);
                $jenis_pesan = "error";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --navy: #1B263B; --navy-l: #415A77; --green: #2D6A4F; --gray: #E0E1DD; --white: #FFFFFF; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-l) 50%, var(--gray) 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="1" fill="%23FFFFFF" opacity="0.05"/></svg>') repeat;
            z-index: -1;
            animation: float 30s linear infinite;
        }
        @keyframes float { 0% { transform: translateY(0); } 100% { transform: translateY(-50px); } }
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 40px;
            border-radius: 25px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.2);
            width: 100%;
            max-width: 400px;
            border: 1px solid rgba(45, 106, 79, 0.3);
            animation: slideIn 0.8s ease-out;
            position: relative;
        }
        @keyframes slideIn { from { opacity: 0; transform: translateY(50px) scale(0.9); } to { opacity: 1; transform: translateY(0) scale(1); } }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--green), var(--navy), var(--green));
            border-radius: 25px 25px 0 0;
        }
        .card h2 {
            text-align: center;
            margin-bottom: 5px;
            color: var(--navy);
            font-weight: 700;
            animation: fadeIn 1s ease-out;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .card p.subtitle {
            text-align: center;
            color: var(--navy-l);
            font-size: 0.9rem;
            margin-bottom: 30px;
            animation: fadeIn 1.2s ease-out;
        }
        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            color: var(--navy);
        }
        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 15px 12px;
            border: 2px solid var(--gray);
            border-radius: 15px;
            font-size: 14px;
            margin-bottom: 16px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }
        input:focus, select:focus {
            border-color: var(--green);
            outline: none;
            box-shadow: 0 0 15px rgba(45, 106, 79, 0.4);
            transform: scale(1.02);
        }
        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, var(--navy), var(--green));
            color: var(--white);
            border: none;
            border-radius: 15px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s ease;
            margin-top: 15px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        button:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        button:hover::before { left: 100%; }
        button:active { transform: translateY(-1px); }
        .pesan-error {
            background: linear-gradient(90deg, #fdecea, #f8d7da);
            color: #c0392b;
            border: 1px solid #f5c6cb;
            padding: 15px 12px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            animation: shake 0.5s ease-out;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
        .pesan-sukses {
            background: linear-gradient(90deg, #eafaf1, #d4edda);
            color: #1e8449;
            border: 1px solid #c3e6cb;
            padding: 15px 12px;
            border-radius: 12px;
            font-size: 13px;
            margin-bottom: 20px;
            animation: fadeIn 0.5s ease-out;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .link-login {
            text-align: center;
            margin-top: 25px;
            font-size: 13px;
            color: var(--navy-l);
            animation: fadeIn 1.4s ease-out;
        }
        .link-login a {
            color: var(--green);
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
            position: relative;
        }
        .link-login a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--green);
            transition: width 0.3s;
        }
        .link-login a:hover::after { width: 100%; }
        .link-login a:hover { color: var(--navy); }
        .hint {
            font-size: 11px;
            color: var(--navy-l);
            margin-top: -12px;
            margin-bottom: 14px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>📝 Register</h2>
    <p class="subtitle">Buat akun baru</p>

    <!-- Tampilkan pesan -->
    <?php if ($pesan != "") : ?>
        <div class="pesan-<?= $jenis_pesan ?>">
            <?= ($jenis_pesan == 'sukses') ? '✅' : '⚠️' ?> <?= $pesan ?>
        </div>
    <?php endif; ?>

    <!-- Form Register -->
    <form method="POST" action="">

        <label for="username">Username</label>
        <input type="text" id="username" name="username" 
               placeholder="Masukkan username"
               value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>">
        <p class="hint">Minimal 4 karakter</p>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Masukkan password">
        <p class="hint">Minimal 6 karakter</p>

        <label for="konfirmasi">Konfirmasi Password</label>
        <input type="password" id="konfirmasi" name="konfirmasi" placeholder="Ulangi password">

        <label for="role">Role / Hak Akses</label>
        <select id="role" name="role">
            <option value="guru">Guru</option>
        </select>

        <button type="submit" name="btn_register">Daftar Sekarang</button>
    </form>

    <div class="link-login">
        Sudah punya akun? <a href="login.php">Login di sini</a>
    </div>
</div>

</body>
</html>