@echo off
setlocal
cd /d %~dp0

echo ========================================
echo BOWO - Instalasi Laravel untuk XAMPP
echo ========================================

echo [1/5] Mengecek PHP XAMPP...
if exist "C:\xampp\php\php.exe" (
    set "PHP=C:\xampp\php\php.exe"
) else (
    echo PHP XAMPP tidak ditemukan di C:\xampp\php\php.exe
    echo Sesuaikan path PHP di file install_xampp.bat jika perlu.
    pause
    exit /b 1
)

"%PHP%" -v
if errorlevel 1 goto error

echo.
echo [2/5] Mengecek Composer...
where composer >nul 2>&1
if errorlevel 1 (
    echo Composer belum ditemukan di PATH Windows.
    echo Install Composer terlebih dahulu, lalu jalankan file ini lagi.
    echo https://getcomposer.org/
    pause
    exit /b 1
)

composer install
if errorlevel 1 goto error

echo.
echo [3/5] Membuat database jika MySQL XAMPP aktif...
"C:\xampp\mysql\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS bowo_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if errorlevel 1 (
    echo Gagal membuat database. Pastikan MySQL XAMPP sudah ON.
    pause
    exit /b 1
)

echo.
echo [4/5] Menyiapkan tabel dan data awal...
"%PHP%" artisan migrate:fresh --seed
if errorlevel 1 goto error

echo.
echo [5/5] BOWO siap.
echo.
echo Pilih salah satu:
echo - Browser Apache: http://localhost/BOWO_Laravel
echo - Server Laravel: php artisan serve
 echo.
pause
exit /b 0

:error
echo.
echo Instalasi gagal. Periksa pesan error di atas.
pause
exit /b 1
