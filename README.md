# 🧾 EA Systems — E-Audit 5S (Laravel)

Aplikasi web untuk mendigitalisasi proses audit 5S  
(Seiri, Seiton, Seiso, Seiketsu, Shitsuke) di lingkungan manufaktur.  

Dibangun dengan **Laravel + MySQL + Tailwind (Blade) + DataTables + Chart.js + Alpine.js**.

---

## 📌 Daftar Isi
- [Requirements](#-requirements)
- [Setup Cepat (Local)](#-setup-cepat-local)
- [Endpoint Login & Akun Contoh](#-endpoint-login--akun-contoh)
- [Fitur Utama](#-fitur-utama)
- [Struktur Proyek](#-struktur-proyek)
- [Deploy (Shared Hosting / VPS)](#️-deploy-shared-hosting--vps)
- [Perintah Berguna](#-perintah-berguna)
- [Troubleshooting](#-troubleshooting)
- [Kontributor](#-kontributor)
- [Lisensi](#-lisensi)

---

## 📦 Requirements
- PHP ≥ 8.1  
  Ekstensi wajib: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Fileinfo
- Composer ≥ 2.x  
- Node.js ≥ 16 (disarankan 18+) + npm  
- MySQL / MariaDB  
- Git  
- (Opsional) XAMPP / Laragon / Valet untuk lokal  

Cek versi cepat:
```bash
php -v
composer -V
node -v
npm -v

🚀 Setup Cepat (Local)

Clone & masuk folder

git clone https://github.com/<username>/ea-systems.git
cd ea-systems


Install dependency

composer install
npm install

# Build production:
npm run build

# atau saat development (HMR):
npm run dev


Siapkan environment

cp .env.example .env
php artisan key:generate


Edit .env (contoh):

APP_NAME="EA Systems"
APP_ENV=local
APP_KEY=base64:... # otomatis terisi
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ea_systems
DB_USERNAME=root
DB_PASSWORD=

# Filesystem
FILESYSTEM_DISK=public


Buat symlink storage (untuk akses file upload)

php artisan storage:link


Migrasi & seeder

php artisan migrate --seed


Seeder akan membuat akun contoh Admin & Auditor.

Jalankan server

php artisan serve


👉 Akses: http://127.0.0.1:8000

🔑 Endpoint Login & Akun Contoh

Auditor

Login: http://127.0.0.1:8000/login

Admin

Login: http://127.0.0.1:8000/admin/login

Dashboard Admin: http://127.0.0.1:8000/admin

Role	Email	Password
Admin	admin@ea.com
	password
Auditor	auditor@ea.com
	password

Setelah login, pengguna akan diarahkan sesuai role.
⚠️ Catatan: jika rute login admin beda (mis. /admin/sign-in), sesuaikan di route.

✨ Fitur Utama

Multi-role: Admin & Auditor

Input temuan audit + unggah foto before/after

Verifikasi & status perbaikan temuan

Halaman laporan & analitik (skor 5S, tren temuan)

Ekspor laporan periode (PDF/Excel; bulanan/periode)

Master data: tema, bagian, jadwal, pengguna

📁 Struktur Proyek
app/Models/              # Model (Audit, Tema, Bagian, User, ...)
app/Http/Controllers/    # AuditController, JadwalController, TemaController, ...
resources/views/         # Blade (laporan/analitik, form, dsb.)
routes/web.php           # Routing web (login, admin, dll.)
database/migrations/     # Skema database
database/seeders/        # Seeder akun & master awal
public/                  # Aset publik (Vite build, uploads via storage link)

🛳️ Deploy (Shared Hosting / VPS)
A. Shared Hosting (tanpa SSH)

Build aset lokal:

npm run build


Edit .env → produksi (APP_ENV=production, APP_DEBUG=false, kredensial DB hosting).

Upload semua file ke hosting. Pastikan document root mengarah ke folder public/.

Jika tidak bisa ubah → pindahkan isi public/ ke root & update path pada index.php (opsi darurat).

Migrasi DB:

Jika tidak ada SSH → ekspor DB lokal kosong atau import via phpMyAdmin.

Jalankan php artisan storage:link jika hosting support Artisan.

Jika tidak → buat symlink manual atau minta support hosting.

B. VPS / SSH
git clone https://github.com/<username>/ea-systems.git
cd ea-systems

composer install --no-dev --optimize-autoloader
npm ci && npm run build

cp .env.example .env
php artisan key:generate   # jika .env baru
# Edit .env produksi (DB, APP_URL, dsb.)

php artisan migrate --force
php artisan storage:link
php artisan optimize


Permission (Linux)

sudo chown -R www-data:www-data storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec chmod 775 {} \;
sudo find storage bootstrap/cache -type f -exec chmod 664 {} \;

🧪 Perintah Berguna
php artisan migrate:fresh --seed   # Reset DB + seed ulang
php artisan route:list             # Cek daftar route
php artisan optimize:clear         # Clear cache config/route/view

🛠️ Troubleshooting

CSS/JS tidak muncul → Jalankan npm run build & cek APP_URL.

Gambar / upload tidak tampil → Jalankan php artisan storage:link & cek permission storage/.

SQLSTATE[HY000] / akses DB gagal → Cek kredensial .env, pastikan DB sudah ada.

404 pada /admin/login → php artisan route:list → pastikan route ada → php artisan route:clear.

Document root tidak ke public/ → Ubah vhost/hosting. Alternatif: pindahkan isi public/ ke root & sesuaikan index.php.

👥 Kontributor

Nur Wardani — Web Developer Intern (EA Systems)

(Tambahkan nama tim lain di sini)

📄 Lisensi

Internal project (PKL/Skripsi).
Tidak untuk penggunaan komersial tanpa izin.
