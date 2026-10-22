# Sistem Aduan Online Parkir Liar

Aplikasi web untuk menerima dan mengelola aduan masyarakat terkait **parkir liar**. Dibuat sebagai tugas **Kerja Praktek (KP)** di **Dinas Perhubungan Kabupaten Bangkalan**.

Masyarakat dapat mengirim aduan secara online, dan admin dapat memantau serta mengelola aduan tersebut melalui dashboard.

> **Catatan:** Repository ini hanya berisi **data contoh (dummy)**. Tidak ada data asli milik instansi.

---

## Fitur

**Masyarakat**
- Mengirim aduan parkir liar melalui formulir online
- Melihat Status Aduan

**Admin**
- Login admin
- Melihat grafik statistik dan daftar aduan yang masuk
- Melihat laporan dan statistik aduan
- Mengelola Aduan
- Logout

---

## Teknologi

| Bagian | Teknologi |
|---|---|
| Bahasa | PHP |
| Database | MySQL |
| Server lokal | XAMPP (Apache + MySQL) |
| Front-end | HTML, CSS, Bootstrap, JavaScript |

Keamanan: password admin disimpan dengan hashing (`password_hash()` dan `password_verify()`), query memakai *prepared statement*.

---

## Screenshot

<!-- Ganti dengan screenshot milikmu. Simpan gambar di folder `screenshots/`. -->

| Halaman | Tampilan |
|---|---|
| Form aduan | ![Form Aduan](screenshots/form-aduan.png)  |
| Login admin | ![Login Admin](screenshots/login-admin.png) |
| Dashboard admin | <img width="1760" height="1197" alt="screencapture-localhost-dishub-aduan-parkir-liar-admin-dashboard-php-2026-10-22-17_40_15" src="https://github.com/user-attachments/assets/d80435ef-51d3-443e-868c-d2de3c2642c1" />
|

---

## Cara Instalasi (Localhost dengan XAMPP)

### 1. Persiapan
Pasang [XAMPP](https://www.apachefriends.org/) terlebih dahulu.

### 2. Salin proyek
Unduh atau clone repository ini, lalu taruh foldernya di:

```
C:\xampp\htdocs\aduan_parkir
```

### 3. Jalankan server
Buka **XAMPP Control Panel**, lalu klik **Start** pada **Apache** dan **MySQL**.

### 4. Impor database
1. Buka `http://localhost/phpmyadmin`
2. Buat database baru, misalnya `aduan_parkir` <!-- sesuaikan dengan nama di connect.php -->
3. Pilih database tersebut, klik tab **Import**
4. Pilih file `database/aduan_parkir.sql`, lalu klik **Go**

### 5. Sesuaikan koneksi database
Buka file `connect.php` dan pastikan isinya sesuai:

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "aduan_parkir"; // sesuaikan dengan nama database kamu
```

### 6. Buka aplikasi
```
http://localhost/aduan_parkir
```

---

## Akun Demo Admin

| Username | Password |
|---|---|
| `admin` | `admin` |

Akun ini hanya untuk **demo**. Jangan dipakai di sistem yang sebenarnya.

---

## Struktur Folder

```
aduan_parkir/
├── database/
│   └── aduan_parkir.sql    # struktur dan data contoh
├── screenshots/            # gambar untuk README
├── connect.php             # koneksi database
├── index.php               # halaman utama / login
├── login.php               # proses login admin
├── dashboard.php           # dashboard admin
└── README.md
```
<!-- Sesuaikan dengan struktur folder yang sebenarnya -->

---

## Informasi Proyek

- **Jenis:** Tugas Kerja Praktek (KP)
- **Instansi:** Dinas Perhubungan Kabupaten Bangkalan
- **Pembuat:** Intan Suci Ramadhani Purnama Kuncoro
- **Program Studi:** Teknik Informatika, Universitas Trunojoyo Madura

---

## Pengembangan Selanjutnya

- <!-- contoh: notifikasi status aduan ke pelapor -->
- <!-- contoh: peta lokasi aduan -->
- <!-- contoh: deploy ke hosting -->

---

## Lisensi

Proyek ini dibuat untuk keperluan pembelajaran dan tugas Kerja Praktek.
