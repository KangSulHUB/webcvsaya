# webcvsaya

Project portfolio berbasis Laravel (Blade) dengan fitur:
- Halaman CV
- Halaman Contact
- Halaman portfolio publik `/project` (untuk HRD)
- Dashboard admin `/admin/projects` (CRUD project + upload file + publish/unpublish)

## Route Utama

- Publik HRD: `GET /project`
- Login admin: `GET /admin/login`
- Dashboard admin: `GET /admin/projects`

## Jalankan Lokal (XAMPP)

1. Install dependency:
```bash
composer install
npm install
```

2. Copy env:
```bash
copy .env.example .env
php artisan key:generate
```

3. Set database di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cvsaya
DB_USERNAME=root
DB_PASSWORD=
```

4. Set login admin di `.env`:
```env
ADMIN_USERNAME=admin
ADMIN_PASSWORD=ganti-password-kamu
```

5. Jalankan migrasi:
```bash
php artisan migrate
```

6. Link storage (untuk file project lokal):
```bash
php artisan storage:link
```

7. Build asset:
```bash
npm run build
```

8. Jalankan server:
```bash
php artisan serve
```

## Cara Pakai CRUD Portfolio

1. Buka `/admin/login`, login dengan username/password admin dari `.env`.
2. Masuk ke `/admin/projects`.
3. Tambah atau edit project:
- Isi `judul` dan `deskripsi`
- Pilih salah satu:
  - upload file lokal (`project_file`)
  - isi `external_url` (misal URL Cloudinary)
- Centang `Tampilkan di publik` agar muncul di `/project`
4. Share link `/project` ke HRD.

## Deploy Gratis (Hosting + DB + Cloud)

Contoh stack gratis:
- Hosting Laravel: Koyeb (Web Service)
- Database gratis: Supabase Postgres
- Cloud file gratis: Cloudinary (pakai URL file pada field `external_url`)

### A. Siapkan Database Gratis (Supabase)

1. Buat project Supabase.
2. Ambil kredensial Postgres.
3. Nanti isi env production:
```env
DB_CONNECTION=pgsql
DB_HOST=...
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=...
DB_PASSWORD=...
```

### B. Deploy Laravel ke Koyeb

1. Push project ke GitHub.
2. Di Koyeb buat Web Service dari repo ini.
3. Build command:
```bash
composer install --no-dev --optimize-autoloader && npm ci && npm run build
```
4. Run command:
```bash
php artisan migrate --force && php artisan storage:link && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=$PORT
```
5. Environment variables minimum:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-kamu.koyeb.app
ADMIN_USERNAME=admin
ADMIN_PASSWORD=pakai-password-kuat
SESSION_DRIVER=file
FILESYSTEM_DISK=public
```
6. Tambahkan variabel DB (Supabase) seperti di langkah A.

### C. Simpan File di Cloudinary (opsional, tetap gratis)

1. Upload image/video project ke Cloudinary.
2. Copy secure URL hasil upload.
3. Tempel ke field `external_url` di admin project.
4. Centang `Tampilkan di publik`.

## Catatan Penting

- Kalau migrasi belum dijalankan, halaman project akan menampilkan pesan error database.
- Untuk keamanan, segera ganti default `ADMIN_USERNAME` dan `ADMIN_PASSWORD`.
- Jika platform gratis mengubah kuota/kebijakan, update konfigurasi deployment sesuai dokumentasi provider.
