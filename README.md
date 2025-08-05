# 🧾 Easy Audit System - User Side

Versi pengguna dari sistem audit 5S berbasis web.  
Dikembangkan dengan Laravel 10 dan Tailwind CSS, sistem ini memudahkan auditor dalam mencatat, memantau, dan mengevaluasi kondisi area kerja secara digital dan efisien.

---

## 🚀 Fitur Utama

- 🔐 Login auditor berbasis email & password
- 📋 Pengisian form audit dengan dokumentasi foto
- 📈 Statistik audit pribadi per waktu
- 🔎 Filter audit berdasarkan tanggal, bagian, dan kategori
- 📁 Riwayat audit dengan status dan detail lengkap
- ⚙️ Pengaturan akun auditor

---

## 🛠️ Teknologi yang Digunakan

- **Framework**: Laravel 10
- **Database**: MySQL
- **UI**: Tailwind CSS + Alpine.js
- **Chart**: Chart.js
- **PDF & Excel**: DomPDF, Laravel Excel
- **Gambar & File**: Intervention Image

---

## ⚙️ Cara Menjalankan Project

```bash
# clone repo
git clone https://github.com/nurwardani03/ea-systems-public.git
cd ea-systems-public

# install dependency Laravel
composer install

# install dependency frontend (opsional)
npm install && npm run dev

# copy konfigurasi env
cp .env.example .env

# generate app key
php artisan key:generate

# atur koneksi database di file .env
DB_DATABASE=nama_database (audit_db.sql)
DB_USERNAME=root
DB_PASSWORD=

# jalankan migrasi dan seeder (jika ada)
php artisan migrate --seed

# mulai server lokal
php artisan serve

# menjalankan sistem
127.0.0.1:8000/login (login auditor)
127.0.0.1:8000/admin/login (login admin)
```

---

## 📦 Struktur Utama

| Folder/File     | Fungsi                            |
|-----------------|-----------------------------------|
| `app/`          | Logic aplikasi (controller, model) |
| `routes/web.php`| Routing utama aplikasi             |
| `resources/`    | View blade dan asset frontend      |
| `public/`       | Entry point web (`index.php`)      |
| `storage/`      | Penyimpanan file/foto audit        |

---

## 📄 Catatan

> Ini adalah versi publik dari sistem audit 5S yang dikembangkan untuk keperluan pembelajaran dan portofolio pribadi.  
> Seluruh data, nama internal, dan struktur khusus perusahaan telah disesuaikan demi menjaga kerahasiaan.

---

## 👤 Pengembang

Dikembangkan oleh **NUR WARDANI (Intern System Developer)**  
Magang semester 7 – Sistem Informasi  
[github.com/nurwardani03](https://github.com/nurwardani03)

---

## 📃 Lisensi

Proyek ini menggunakan lisensi MIT – bebas digunakan untuk pembelajaran dan pengembangan pribadi.
