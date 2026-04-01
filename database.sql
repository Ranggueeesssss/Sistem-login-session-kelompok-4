-- 1. Buat database (jika belum ada)
CREATE DATABASE IF NOT EXISTS db_login;
USE db_login;

-- 2. Buat tabel tb_login
CREATE TABLE IF NOT EXISTS tb_login (
    id_user  INT(11)      AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,          -- Disimpan dalam format MD5
    role     ENUM('admin','guru')       NOT NULL DEFAULT 'guru'
);

-- 3. Insert data contoh (password = "admin123" di-hash MD5)
INSERT INTO tb_login (username, password, role) VALUES
('admin',     MD5('admin123'),    'admin'),
('budi',      MD5('budi123'),     'guru'),
('sari',      MD5('sari123'),     'guru');

-- Setelah ini kamu bisa login dengan:
-- username: admin     | password: admin123   -> masuk ke Dashboard Admin
-- username: budi      | password: budi123    -> masuk ke Dashboard Mahasiswa