# SIPERPUS - Sistem Informasi Perpustakaan

Aplikasi web berbasis **PHP Native + MySQL** untuk memenuhi tugas praktikum Pengembangan Sistem Informasi Berbasis Web.

## Fitur yang Tersedia

### Fitur Wajib
1. **Login & Hak Akses** — 2 role (Admin & Petugas)
2. **CRUD Data Utama** — Data Buku
3. **CRUD Data Pendukung** — Data Anggota
4. **Transaksi** — Peminjaman buku (stok otomatis berkurang)
5. **Penyelesaian Transaksi** — Pengembalian buku (stok otomatis bertambah + denda keterlambatan)
6. **Dashboard & Laporan** — Ringkasan statistik, buku populer, anggota aktif, daftar keterlambatan

### Fitur Tambahan
- Perhitungan denda otomatis (Rp 1.000 / hari keterlambatan)
- Fitur pencarian & filter data
- UI responsif menggunakan Bootstrap 5
- Prepared Statement (aman dari SQL Injection)
- Password di-hash dengan `password_hash()`

---

## Cara Instalasi

### 1. Persyaratan
- XAMPP / Laragon / WAMP (PHP 7.4+ & MySQL)
- Browser modern

### 2. Langkah-langkah

1. **Copy folder** `siperpus` ke dalam folder web server:
   - XAMPP → `C:\xampp\htdocs\`
   - Laragon → `C:\laragon\www\`

2. **Buat database**
   - Buka phpMyAdmin → http://localhost/phpmyadmin
   - Import file `database.sql`
   - Atau jalankan query di dalamnya secara manual

3. **Sesuaikan koneksi database** (jika perlu)
   - Buka file `config/database.php`
   - Ubah `DB_USER` dan `DB_PASS` sesuai pengaturan MySQL kamu

4. **Jalankan aplikasi**
   - Buka browser → http://localhost/siperpus

---

## Akun Login Demo

| Role    | Username  | Password    |
|---------|-----------|-------------|
| Admin   | `admin`   | `admin123`  |
| Petugas | `petugas` | `petugas123`|

---

## Struktur Folder

```
siperpus/
├── config/
│   └── database.php          # Koneksi database
├── includes/
│   ├── auth.php              # Session & cek login
│   ├── header.php            # Header + Sidebar
│   └── footer.php
├── pages/
│   ├── dashboard.php
│   ├── buku/                 # CRUD Buku
│   ├── anggota/              # CRUD Anggota
│   ├── peminjaman/           # Transaksi Pinjam & Kembali
│   └── laporan/
├── assets/
├── database.sql              # File SQL database
├── index.php
├── login.php
└── logout.php
```

---

## Alur Transaksi

1. **Peminjaman**
   - Pilih anggota + buku (hanya yang stok > 0)
   - Stok buku otomatis **berkurang 1**
   - Status = `dipinjam`

2. **Pengembalian**
   - Klik tombol "Kembali"
   - Jika lewat tanggal kembali → **denda otomatis** dihitung
   - Stok buku otomatis **bertambah 1**
   - Status = `dikembalikan`

---

## Catatan untuk Penilaian

- Semua query menggunakan **Prepared Statement**
- Validasi input dilakukan di sisi server
- Struktur folder rapi (config / includes / pages terpisah)
- Relasi antar tabel jelas (Foreign Key)
- UI bersih dan mudah digunakan

Semoga nilainya bagus! 🚀
