CREATE DATABASE db_siswa;
USE db_siswa;

CREATE TABLE siswa (
    nisn VARCHAR(10) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    kelas VARCHAR(20) NOT NULL
);
