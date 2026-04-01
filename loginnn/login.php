<?php
session_start();
include "koneksi.php";

$pesan = "";
if (isset($_POST['btn_login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $pesan = "Username dan password tidak boleh kosong!";
    } else {
        $query  = "SELECT * FROM tb_login WHERE username = '$username' AND password = MD5('$password')";
        $hasil  = mysqli_query($koneksi, $query);
        $jumlah = mysqli_num_rows($hasil);

        if ($jumlah == 1) {
            $data = mysqli_fetch_assoc($hasil);
            $_SESSION['id_user']  = $data['id_user'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role']     = $data['role'];

            if ($data['role'] == 'admin') {
                header("Location: dashboard_admin.php");
            } else {
                header("Location: dashboard_mahasiswa.php");
            }
            exit();
        } else {
            $pesan = "Username atau password salah!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - POLIJE System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --navy: #1B263B; --navy-l: #415A77; --green: #2D6A4F; --gray: #E0E1DD; --white: #FFFFFF; }
        body { 
            font-family: 'Poppins', sans-serif; 
            background: linear-gradient(135deg, var(--navy) 0%, var(--navy-l) 50%, var(--gray) 100%); 
            margin: 0; 
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
            max-width: 380px; 
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
        h2 { text-align: center; color: var(--navy); margin-bottom: 5px; font-weight: 700; animation: fadeIn 1s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .subtitle { text-align: center; color: var(--navy-l); font-size: 0.9rem; margin-bottom: 30px; animation: fadeIn 1.2s ease-out; }
        input { 
            width: 100%; 
            padding: 15px; 
            margin: 12px 0; 
            border: 2px solid var(--gray); 
            border-radius: 15px; 
            box-sizing: border-box; 
            font-size: 1rem; 
            transition: all 0.3s ease; 
            background: rgba(255, 255, 255, 0.8); 
        }
        input:focus { 
            border-color: var(--green); 
            outline: none; 
            box-shadow: 0 0 15px rgba(45, 106, 79, 0.4); 
            transform: scale(1.02); 
        }
        button { 
            width: 100%; 
            background: linear-gradient(45deg, var(--navy), var(--green)); 
            color: var(--white); 
            padding: 15px; 
            border: none; 
            border-radius: 15px; 
            font-weight: 600; 
            font-size: 1rem; 
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
        .error { 
            background: linear-gradient(90deg, #fdecea, #f8d7da); 
            color: #c0392b; 
            padding: 15px; 
            border-radius: 12px; 
            font-size: 0.9rem; 
            text-align: center; 
            margin-bottom: 20px; 
            border: 1px solid #f5c6cb; 
            animation: shake 0.5s ease-out; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
        }
        @keyframes shake { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-5px); } 75% { transform: translateX(5px); } }
        .footer { 
            text-align: center; 
            margin-top: 25px; 
            font-size: 0.9rem; 
            color: var(--navy-l); 
            animation: fadeIn 1.4s ease-out; 
        }
        .footer a { 
            color: var(--green); 
            text-decoration: none; 
            font-weight: bold; 
            transition: all 0.3s ease; 
            position: relative; 
        }
        .footer a::after { 
            content: ''; 
            position: absolute; 
            bottom: -2px; 
            left: 0; 
            width: 0; 
            height: 2px; 
            background: var(--green); 
            transition: width 0.3s; 
        }
        .footer a:hover::after { width: 100%; }
        .footer a:hover { color: var(--navy); }
    </style>
</head>
<body>
    <div class="card">
        <h2>🔐 Login</h2>
        <p class="subtitle">Silahkan masuk ke akun anda</p>
        <?php if ($pesan != "") : ?><div class="error">⚠️ <?= $pesan ?></div><?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="btn_login">Masuk Sekarang</button>
        </form>
        <div class="footer">Belum punya akun? <a href="register.php">Daftar di sini</a></div>
    </div>
</body>
</html>