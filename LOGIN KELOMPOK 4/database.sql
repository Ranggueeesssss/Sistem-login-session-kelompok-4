CREATE DATABASE IF NOT EXISTS db_login;
USE db_login;

CREATE TABLE IF NOT EXISTS tb_login (
    id_user  INT(11)      AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50)  NOT NULL UNIQUE,
    password VARCHAR(100) NOT NULL,          -- Disimpan dalam format MD5
    role     ENUM('admin','guru')       NOT NULL DEFAULT 'guru'
);

INSERT INTO tb_login (username, password, role) VALUES
('admin',     MD5('admin123'),    'admin'),
('budi',      MD5('budi123'),     'guru'),
('sari',      MD5('sari123'),     'guru');
