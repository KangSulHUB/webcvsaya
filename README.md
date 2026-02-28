# webcvsaya

Project CV berbasis Laravel (Blade) dengan fitur:
- Halaman CV
- Halaman Contact
- CRUD Project + upload file

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

4. Jalankan migrasi:
```bash
php artisan migrate
```

5. Link storage (untuk file project):
```bash
php artisan storage:link
```

6. Build asset:
```bash
npm run build
```

7. Jalankan server:
```bash
php artisan serve
```

## Deploy Laravel Full (cPanel / shared hosting / VPS)

1. Jalankan script prepare dari lokal (PowerShell):
```powershell
powershell -ExecutionPolicy Bypass -File .\scripts\prepare-production.ps1
```

2. Copy `.env.production.example` menjadi `.env` di server, lalu isi:
- `APP_KEY` (hasilkan dengan `php artisan key:generate` di server)
- `APP_URL`
- kredensial database hosting

3. Upload project ke hosting (Laravel full):
- Simpan source Laravel di luar `public_html`
- Pindahkan isi folder `public/` ke `public_html`
- Edit `public_html/index.php` agar mengarah ke folder source Laravel

4. Setup database di server:
```bash
php artisan migrate --force
php artisan storage:link
```

5. Optimasi cache di server:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

6. Pastikan permission:
- `storage/` writable
- `bootstrap/cache/` writable

## Catatan Penting

Project ini adalah Laravel full (PHP + MySQL), bukan static site.

- Cocok: cPanel/shared hosting, VPS, platform dengan PHP runtime.
- Tidak cocok untuk deploy full fitur backend di Vercel static-only.
