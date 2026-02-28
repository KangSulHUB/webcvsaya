Param(
    [switch]$SkipComposer,
    [switch]$SkipNpm
)

$ErrorActionPreference = "Stop"

Write-Host "== Laravel production prepare =="

Write-Host "1) Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

if (-not $SkipComposer) {
    Write-Host "2) Installing composer production dependencies..."
    composer install --no-dev --optimize-autoloader
}

if (-not $SkipNpm) {
    Write-Host "3) Installing node modules and building assets..."
    npm install
    npm run build
}

Write-Host "4) Building Laravel cache for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

Write-Host "Done. Next on server: php artisan migrate --force && php artisan storage:link"
