-- Database: db_servis_mobil
-- Sistem Informasi Servis Mobil (SIBENGKEL)

CREATE DATABASE IF NOT EXISTS db_servis_mobil;
USE db_servis_mobil;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    role ENUM('admin', 'petugas') NOT NULL DEFAULT 'petugas',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pelanggan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    no_hp VARCHAR(20),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE mobil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pelanggan INT NOT NULL,
    no_polisi VARCHAR(20) NOT NULL UNIQUE,
    merek VARCHAR(50) NOT NULL,
    tipe VARCHAR(50) NOT NULL,
    tahun YEAR,
    warna VARCHAR(30),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id) ON DELETE CASCADE
);

CREATE TABLE servis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_mobil INT NOT NULL,
    id_pelanggan INT NOT NULL,
    id_petugas INT NOT NULL,
    keluhan TEXT NOT NULL,
    tanggal_masuk DATE NOT NULL,
    tanggal_selesai DATE NULL,
    biaya INT DEFAULT 0,
    status ENUM('proses', 'selesai') NOT NULL DEFAULT 'proses',
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_mobil) REFERENCES mobil(id) ON DELETE CASCADE,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id) ON DELETE CASCADE,
    FOREIGN KEY (id_petugas) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO users (username, password, nama, role) VALUES
('admin', '$2y$10$W0NgvvWP5sj34620FsKAZ.pf09xJIdPtqngyAhoNLOyyqKhzQ22r2', 'Administrator', 'admin'),
('petugas', '$2y$10$fW5MMJKu4hv/YAaOQ2gXWu21TnZcSet9kzqbE5R3Kde9nnUmGA86y', 'Petugas Bengkel', 'petugas');

INSERT INTO pelanggan (nama, email, no_hp, alamat) VALUES
('Budi Santoso', 'budi@email.com', '081234567890', 'Jl. Merdeka No. 10'),
('Siti Aminah', 'siti@email.com', '081298765432', 'Jl. Sudirman No. 25'),
('Andi Wijaya', 'andi@email.com', '081345678901', 'Jl. Gatot Subroto No. 5'),
('Rina Kartika', 'rina@email.com', '081376543210', 'Jl. Ahmad Yani No. 15');

INSERT INTO mobil (id_pelanggan, no_polisi, merek, tipe, tahun, warna) VALUES
(1, 'B 1234 ABC', 'Toyota', 'Avanza', 2020, 'Putih'),
(1, 'B 5678 DEF', 'Honda', 'Civic', 2019, 'Hitam'),
(2, 'D 9012 GHI', 'Suzuki', 'Ertiga', 2021, 'Silver'),
(3, 'F 3456 JKL', 'Mitsubishi', 'Pajero', 2018, 'Abu-abu'),
(4, 'B 7890 MNO', 'Daihatsu', 'Xenia', 2022, 'Merah');
