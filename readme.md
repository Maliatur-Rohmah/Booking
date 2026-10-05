# Sistem Booking Lapangan Futsal

Sistem booking lapangan futsal berbasis PHP dan MySQL untuk membantu admin mengelola reservasi, memantau status pembayaran, serta melihat ringkasan data booking secara cepat.

## Fitur utama

- Login admin untuk mengakses panel sistem
- Dashboard ringkasan booking
- Tambah data booking baru
- Edit dan hapus data booking
- Filter data booking berdasarkan nama pelanggan dan status
- Pencatatan status booking:
  - Belum Lunas
  - Lunas
  - Dibatalkan
- Perhitungan total bayar otomatis berdasarkan jam sewa dan harga per jam
- Tampilan responsif dengan Bootstrap

## Teknologi yang digunakan

- PHP 8+
- MySQL / MariaDB
- Bootstrap 5
- JavaScript
- XAMPP / Apache

## Struktur project

```text
project_booking/
├── assets/
│   ├── css/
│   ├── images/
│   └── js/
├── config/
│   └── koneksi.php
├── includes/
│   ├── cek_session.php
│   ├── footer.php
│   ├── navbar.php
│   └── sidebar.php
├── booking.php
├── dashboard.php
├── edit_booking.php
├── hapus_booking.php
├── login.php
├── logout.php
├── proses_login.php
├── readme.md
├── tambah_booking.php
└── ...
```

## Persyaratan

- XAMPP / WAMP / Laragon
- PHP 8 atau versi yang lebih baru
- MySQL
- Browser modern (Chrome, Edge, Firefox)

## Setup dan instalasi

1. Salin project ini ke folder web server, misalnya:

```text
C:/xampp/htdocs/project_booking
```

2. Buat database MySQL dengan nama `db_futsal`.

3. Pastikan konfigurasi koneksi database sudah sesuai di file `config/koneksi.php`:

```php
<?php
$host   = "localhost";
$user   = "root";
$pass   = "";
$dbname = "db_futsal";
```

4. Buat tabel `admin` dan `booking` pada database `db_futsal`.

### Contoh struktur tabel

```sql
CREATE DATABASE IF NOT EXISTS db_futsal;
USE db_futsal;

CREATE TABLE admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE booking (
    id_booking INT AUTO_INCREMENT PRIMARY KEY,
    id_admin INT,
    nama_pelanggan VARCHAR(150) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    lapangan VARCHAR(50) NOT NULL,
    tanggal_booking DATE NOT NULL,
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    harga_per_jam INT NOT NULL,
    total_bayar INT NOT NULL,
    status_booking VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_admin) REFERENCES admin(id_admin)
);
```

### Contoh data admin

```sql
INSERT INTO admin (username, password) VALUES ('admin', 'admin123');
```

> Anda dapat mengganti username dan password sesuai kebutuhan.

5. Jalankan aplikasi di browser:

```text
http://localhost/project_booking/login.php
```

## Cara penggunaan

1. Buka halaman login.
2. Masukkan username dan password admin.
3. Setelah login, akan masuk ke halaman dashboard.
4. Dari dashboard, admin dapat melihat statistik booking dan data terbaru.
5. Pilih menu Data Booking untuk melihat seluruh reservasi.
6. Klik tombol Tambah Booking untuk menambahkan reservasi baru.
7. Edit atau hapus booking sesuai kebutuhan.

## Catatan

- Aplikasi ini bersifat sederhana dan cocok untuk kebutuhan administrasi booking lapangan futsal kecil hingga menengah.
- Disarankan untuk mengganti konfigurasi database default dan password admin setelah sistem digunakan di lingkungan produksi.
- Jika muncul error koneksi database, pastikan MySQL aktif dan nama database sesuai dengan konfigurasi di `config/koneksi.php`.

## Lisensi

Proyek ini dibuat untuk kebutuhan pembelajaran dan pengelolaan booking lapangan futsal sederhana. Silakan sesuaikan sesuai kebutuhan project Anda.
