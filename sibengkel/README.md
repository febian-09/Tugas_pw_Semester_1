# SIBENGKEL - Sistem Informasi Servis Mobil

Aplikasi web **PHP Native + MySQL** untuk tugas Pengembangan Sistem Informasi Berbasis Web.

## Fitur Wajib
1. Login & Hak Akses (Admin + Petugas)
2. CRUD Data Utama → **Mobil** (no polisi, merek, tipe, dll)
3. CRUD Data Pendukung → **Pelanggan**
4. Transaksi **Servis** (status: Proses)
5. Penyelesaian Transaksi → **Selesai Servis** (input biaya final)
6. Dashboard & Laporan

## Bonus
- Pencarian & filter
- UI Bootstrap 5 responsif
- Prepared Statement (aman SQL Injection)

## Instalasi
1. Copy folder `sibengkel` ke htdocs/www
2. Import `database.sql` di phpMyAdmin
3. Sesuaikan `config/database.php` jika perlu
4. Buka http://localhost/sibengkel

## Akun Login
| Role    | Username  | Password     |
|---------|-----------|--------------|
| Admin   | admin     | admin123     |
| Petugas | petugas   | petugas123   |

## Koneksi Database
File: `config/database.php`
- Host: localhost
- User: root
- Pass: (kosong)
- Database: db_servis_mobil
