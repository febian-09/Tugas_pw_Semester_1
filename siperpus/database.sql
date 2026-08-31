-- Database: db_perpustakaan
-- Sistem Informasi Perpustakaan (SIPERPUS)

CREATE DATABASE IF NOT EXISTS db_perpustakaan;
USE db_perpustakaan;

-- Tabel Users (Admin & Petugas)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    role ENUM('admin', 'petugas') NOT NULL DEFAULT 'petugas',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Anggota
CREATE TABLE anggota (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    no_hp VARCHAR(20),
    alamat TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Buku
CREATE TABLE buku (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(200) NOT NULL,
    penulis VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100),
    tahun YEAR,
    stok INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel Peminjaman
CREATE TABLE peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_anggota INT NOT NULL,
    id_buku INT NOT NULL,
    id_petugas INT NOT NULL,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE NOT NULL,
    tanggal_dikembalikan DATE NULL,
    status ENUM('dipinjam', 'dikembalikan') NOT NULL DEFAULT 'dipinjam',
    denda INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_anggota) REFERENCES anggota(id) ON DELETE CASCADE,
    FOREIGN KEY (id_buku) REFERENCES buku(id) ON DELETE CASCADE,
    FOREIGN KEY (id_petugas) REFERENCES users(id) ON DELETE CASCADE
);

-- Data awal Users
-- Username: admin     | Password: admin123
-- Username: petugas   | Password: petugas123
INSERT INTO users (username, password, nama, role) VALUES
('admin', '$2y$10$CiOlV4BDAW/oSDOPDbbpYuCzPIjLglxsYpP.XHnW94QZ8Pz4A7mvG', 'Administrator', 'admin'),
('petugas', '$2y$10$Pc2WnveO575W47JkzPVPfOyDv8.Uv1U89lqUXQtDkAktS/I2znr3y', 'Petugas Perpustakaan', 'petugas');


-- Data contoh Anggota
INSERT INTO anggota (nama, email, no_hp, alamat) VALUES
('Ahmad Fauzi', 'ahmad@email.com', '081234567890', 'Jl. Merdeka No. 10'),
('Siti Nurhaliza', 'siti@email.com', '081298765432', 'Jl. Sudirman No. 25'),
('Budi Santoso', 'budi@email.com', '081345678901', 'Jl. Gatot Subroto No. 5');

-- Data contoh Buku
INSERT INTO buku (judul, penulis, penerbit, tahun, stok) VALUES
('Pemrograman Web dengan PHP', 'Budi Raharjo', 'Informatika', 2023, 10),
('Database MySQL untuk Pemula', 'Andi Wijaya', 'Andi Publisher', 2022, 8),
('Algoritma dan Struktur Data', 'Rinaldi Munir', 'Informatika', 2021, 5),
('Jaringan Komputer', 'Forouzan', 'McGraw-Hill', 2020, 7),
('Sistem Operasi', 'Abraham Silberschatz', 'Wiley', 2019, 6);
