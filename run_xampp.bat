@echo off
cd /d %~dp0
if not exist vendor\autoload.php (
    echo Dependency Laravel belum terpasang. Jalankan install_xampp.bat terlebih dahulu.
    pause
    exit /b 1
)
start "BOWO Laravel" cmd /k "php artisan serve --host=127.0.0.1 --port=8000"
start http://127.0.0.1:8000
echo Server Laravel dibuka di http://127.0.0.1:8000
