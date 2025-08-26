# EA Systems — E-Audit 5S (Laravel)

Aplikasi web untuk mendigitalisasi audit 5S (Seiri, Seiton, Seiso, Seiketsu, Shitsuke) di lingkungan manufaktur: input temuan, verifikasi, upload foto sebelum/sesudah, dashboard, dan laporan periode (PDF/Excel).  
Tech stack: **Laravel**, **MySQL**, **Blade + Tailwind**, **DataTables**, **Chart.js**, **Alpine.js**, **Vite**.

---

## 📦 Requirements
- **PHP** ≥ 8.1 (ext: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Fileinfo)
- **Composer** ≥ 2.x
- **Node.js** ≥ 16 (disarankan 18+) + **npm**
- **MySQL/MariaDB**
- **Git**
- (Opsional dev lokal) XAMPP / Laragon / Valet

Cek versi cepat:
```bash
php -v
composer -V
node -v
npm -v
```
⚙️ Cara Menjalankan Project
```bash
# clone repo
git clone https://github.com/nurwardani03/ea-systems-public.git
cd ea-systems-public

# install dependency backend
composer install

# install dependency frontend (opsional saat dev)
npm install
npm run dev   # atau npm run build untuk produksi

# copy konfigurasi env
cp .env.example .env

# generate app key
php artisan key:generate
```

Atur koneksi database di file .env:
```bash
APP_NAME="Easy Audit System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=audit_db.sql
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

Lanjutkan inisialisasi:
```bash
# buat symlink untuk akses file upload
php artisan storage:link

# migrasi & seeder
php artisan migrate --seed

# mulai server lokal
php artisan serve
```

Akses aplikasi:
127.0.0.1:8000/login        # login auditor
127.0.0.1:8000/admin/login  # login admin

📦 Struktur Utama
Folder/File	Fungsi
app/	Logic aplikasi (controller, model)
routes/web.php	Routing utama aplikasi
resources/	View Blade dan aset frontend
public/	Entry point web (index.php)
storage/	Penyimpanan file/foto audit
database/	Migrasi & seeder

📄 Catatan
Ini adalah versi publik dari sistem audit 5S yang dikembangkan untuk keperluan pembelajaran dan portofolio pribadi.
Seluruh data, nama internal, dan struktur khusus perusahaan telah disesuaikan demi menjaga kerahasiaan.

👤 Pengembang
Dikembangkan oleh NUR WARDANI (Intern System Development)
Magang Semester 7 – Sistem Informasi
github.com/nurwardani03

📃 Lisensi
Lisensi MIT – bebas digunakan untuk pembelajaran dan pengembangan pribadi.
