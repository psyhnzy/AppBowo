<?php
/**
 * BOWO - Database Initializer (MySQL / SQLite untuk XAMPP)
 * Kunjungi sekali: http://localhost/BOWO_Laravel/public/setup.php?key=bowo-setup-2026
 * HAPUS file ini setelah selesai!
 */

$secret = 'bowo-setup-2026';
if (!isset($_GET['key']) || $_GET['key'] !== $secret) {
    http_response_code(403);
    die('<h2 style="font-family:monospace;color:red">403 Forbidden</h2><p>Akses: <code>?key=bowo-setup-2026</code></p>');
}

// ----------------------------------------------------------------
// BACA KONFIGURASI .ENV
// ----------------------------------------------------------------
$envFile = __DIR__ . '/../.env';
$env = [];
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if (str_starts_with($line, '#')) continue;
        if (str_contains($line, '=')) {
            [$k, $v] = explode('=', $line, 2);
            $env[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        }
    }
}

$driver   = $env['DB_CONNECTION'] ?? 'mysql';
$host     = $env['DB_HOST'] ?? '127.0.0.1';
$port     = $env['DB_PORT'] ?? '3306';
$database = $env['DB_DATABASE'] ?? 'bowo_db';
$username = $env['DB_USERNAME'] ?? 'root';
$password = $env['DB_PASSWORD'] ?? '';

$log = [];

try {
    if ($driver === 'mysql') {
        $log[] = ['ok', "Driver terdeteksi: MySQL ($host:$port)"];

        // 1. Hubungkan ke server MySQL
        $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        $log[] = ['ok', 'Koneksi ke server MySQL XAMPP berhasil'];

        // 2. Buat database jika belum ada
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `{$database}`");
        $log[] = ['ok', "Database `{$database}` siap digunakan"];

        // 3. Drop tabel lama jika ada agar bersih (urutan dari foreign key)
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $pdo->exec("DROP TABLE IF EXISTS targets, transactions, deposits, waste_types, users, migrations;");
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
        $log[] = ['ok', 'Tabel lama dibersihkan'];

        // 4. Buat tabel-tabel
        $tables = [
            'migrations' => "CREATE TABLE migrations (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                migration VARCHAR(255) NOT NULL,
                batch INT NOT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

            'users' => "CREATE TABLE users (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100) NOT NULL,
                username VARCHAR(50) NOT NULL UNIQUE,
                email VARCHAR(100) NOT NULL UNIQUE,
                phone VARCHAR(20) NOT NULL,
                address TEXT NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(10) NOT NULL DEFAULT 'nasabah',
                balance DECIMAL(12,2) NOT NULL DEFAULT 0.00,
                points INT NOT NULL DEFAULT 0,
                status VARCHAR(10) NOT NULL DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

            'waste_types' => "CREATE TABLE waste_types (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                category VARCHAR(50) NOT NULL,
                price_per_kg DECIMAL(10,2) NOT NULL,
                description TEXT NULL,
                status VARCHAR(10) NOT NULL DEFAULT 'active',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

            'deposits' => "CREATE TABLE deposits (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL,
                waste_type_id BIGINT UNSIGNED NOT NULL,
                weight DECIMAL(8,2) NOT NULL,
                price_per_kg DECIMAL(10,2) NOT NULL,
                total_value DECIMAL(12,2) NOT NULL,
                points INT NOT NULL,
                deposit_date DATE NOT NULL,
                notes TEXT NULL,
                status VARCHAR(15) NOT NULL DEFAULT 'menunggu',
                verified_by BIGINT UNSIGNED NULL,
                verified_at DATETIME NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_deposits_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                CONSTRAINT fk_deposits_waste FOREIGN KEY (waste_type_id) REFERENCES waste_types(id) ON DELETE CASCADE,
                CONSTRAINT fk_deposits_verifier FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

            'transactions' => "CREATE TABLE transactions (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL,
                deposit_id BIGINT UNSIGNED NULL,
                type VARCHAR(20) NOT NULL,
                amount DECIMAL(12,2) NOT NULL,
                description TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_transactions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                CONSTRAINT fk_transactions_deposit FOREIGN KEY (deposit_id) REFERENCES deposits(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",

            'targets' => "CREATE TABLE targets (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                user_id BIGINT UNSIGNED NOT NULL,
                target_weight DECIMAL(8,2) NOT NULL DEFAULT 10.00,
                period VARCHAR(20) NOT NULL DEFAULT 'Bulan Ini',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_targets_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        ];

        foreach ($tables as $name => $sql) {
            $pdo->exec($sql);
            $log[] = ['ok', "Tabel `{$name}` berhasil dibuat"];
        }

    } else {
        // Fallback SQLite jika .env dikembalikan ke sqlite
        $dbPath = __DIR__ . '/../database/bowo.sqlite';
        if (file_exists($dbPath)) {
            @unlink($dbPath);
        }
        $pdo = new PDO('sqlite:' . $dbPath);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('PRAGMA foreign_keys = ON;');
        $log[] = ['ok', 'Koneksi SQLite berhasil dibuat'];

        // Tabel SQLite sederhana
        $pdo->exec("CREATE TABLE migrations (id INTEGER PRIMARY KEY AUTOINCREMENT, migration VARCHAR(255) NOT NULL, batch INTEGER NOT NULL)");
        $pdo->exec("CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR(100), username VARCHAR(50) UNIQUE, email VARCHAR(100) UNIQUE, phone VARCHAR(20), address TEXT, password VARCHAR(255), role VARCHAR(10) DEFAULT 'nasabah', balance DECIMAL(12,2) DEFAULT 0, points INTEGER DEFAULT 0, status VARCHAR(10) DEFAULT 'active', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
        $pdo->exec("CREATE TABLE waste_types (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR(50), category VARCHAR(50), price_per_kg DECIMAL(10,2), description TEXT, status VARCHAR(10) DEFAULT 'active', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
        $pdo->exec("CREATE TABLE deposits (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER, waste_type_id INTEGER, weight DECIMAL(8,2), price_per_kg DECIMAL(10,2), total_value DECIMAL(12,2), points INTEGER, deposit_date DATE, notes TEXT, status VARCHAR(15) DEFAULT 'menunggu', verified_by INTEGER, verified_at DATETIME, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
        $pdo->exec("CREATE TABLE transactions (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER, deposit_id INTEGER, type VARCHAR(20), amount DECIMAL(12,2), description TEXT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
        $pdo->exec("CREATE TABLE targets (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER, target_weight DECIMAL(8,2) DEFAULT 10, period VARCHAR(20) DEFAULT 'Bulan Ini', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
        $log[] = ['ok', 'Tabel SQLite berhasil dibuat'];
    }

    // ----------------------------------------------------------------
    // ISI DATA AWAL (SEEDERS)
    // ----------------------------------------------------------------
    $users = [
        [1, 'Administrator BOWO', 'admin', 'admin@bowo.id', '081234567890', 'Kantor Pusat BOWO',
         password_hash('admin123', PASSWORD_BCRYPT), 'admin', 0.00, 0, 'active'],
        [2, 'Budi Santoso', 'budi', 'budi@gmail.com', '081298765432', 'Jl. Merdeka No. 12',
         password_hash('password123', PASSWORD_BCRYPT), 'nasabah', 25000.00, 50, 'active'],
        [3, 'Siti Rahma', 'siti', 'siti@gmail.com', '085612345678', 'Jl. Mawar No. 5',
         password_hash('password123', PASSWORD_BCRYPT), 'nasabah', 40000.00, 80, 'active'],
    ];
    $stmt = $pdo->prepare("INSERT INTO users (id, name, username, email, phone, address, password, role, balance, points, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($users as $u) {
        $stmt->execute($u);
    }
    $log[] = ['ok', 'Data awal users berhasil diisi (admin, budi, siti)'];

    $wastes = [
        [1, 'Plastik PET (Botol Bening)', 'Plastik', 5000.00, 'Botol air mineral bekas bersih tanpa label', 'active'],
        [2, 'Kertas Dupleks / Dus',        'Kardus',  2500.00, 'Kardus bekas kemasan, bersih dan kering',    'active'],
        [3, 'Kertas HVS / Buku',           'Kertas',  3000.00, 'Kertas putih bekas cetak atau buku tulis',   'active'],
        [4, 'Kaleng / Besi Tipis',          'Logam',   8000.00, 'Kaleng minuman atau wadah makanan logam',    'active'],
    ];
    $stmt = $pdo->prepare("INSERT INTO waste_types (id, name, category, price_per_kg, description, status) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($wastes as $w) {
        $stmt->execute($w);
    }
    $log[] = ['ok', 'Data jenis sampah berhasil diisi'];

    $targets = [
        [1, 2, 10.00, 'Bulan Ini'],
        [2, 3, 15.00, 'Bulan Ini'],
    ];
    $stmt = $pdo->prepare("INSERT INTO targets (id, user_id, target_weight, period) VALUES (?, ?, ?, ?)");
    foreach ($targets as $t) {
        $stmt->execute($t);
    }
    $log[] = ['ok', 'Data target nasabah berhasil diisi'];

    $migrations = [
        '2026_09_29_000001_create_users_table',
        '2026_09_29_000002_create_waste_types_table',
        '2026_09_29_000003_create_deposits_table',
        '2026_09_29_000004_create_transactions_table',
        '2026_09_29_000005_create_targets_table',
    ];
    $stmt = $pdo->prepare("INSERT INTO migrations (migration, batch) VALUES (?, 1)");
    foreach ($migrations as $m) {
        $stmt->execute([$m]);
    }
    $log[] = ['ok', 'Riwayat migrasi Laravel dicatat'];

    $success = true;
} catch (Throwable $e) {
    $log[] = ['err', 'ERROR: ' . $e->getMessage()];
    $success = false;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOWO &mdash; Setup Database MySQL</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: #0f172a;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .container {
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 32px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);
        }
        h1 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #38bdf8;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid #334155;
        }
        .log {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 24px;
            font-family: 'Consolas', monospace;
            font-size: 0.88rem;
        }
        .log-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 6px 10px;
            border-radius: 6px;
            background: #0f172a;
        }
        .ok { color: #4ade80; font-weight: bold; }
        .err { color: #f87171; font-weight: bold; }
        .banner {
            padding: 12px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 20px;
        }
        .banner.success { background: #064e3b; color: #6ee7b7; border: 1px solid #059669; }
        .banner.failed  { background: #450a0a; color: #fca5a5; border: 1px solid #dc2626; }
        .links a {
            display: inline-block;
            background: #0284c7;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: background 0.2s;
        }
        .links a:hover { background: #0369a1; }
        .warn {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-top: 16px;
            line-height: 1.5;
        }
        code { background: #0f172a; padding: 2px 6px; border-radius: 4px; font-family: monospace; }
    </style>
</head>
<body>
    <div class="container">
        <h1>BOWO &mdash; Setup Database MySQL XAMPP</h1>

        <div class="log">
            <?php foreach ($log as [$type, $msg]): ?>
                <div class="log-item">
                    <span class="<?= $type ?>"><?= $type === 'ok' ? '✓' : '✗' ?></span>
                    <span><?= htmlspecialchars($msg) ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($success): ?>
            <div class="banner success">
                ✅ Database MySQL (<code><?= htmlspecialchars($database) ?></code>) berhasil disiapkan!
            </div>
            <div class="links">
                <a href="../">Buka Aplikasi BOWO</a>
            </div>
            <div class="warn">
                ⚠️ Anda sekarang dapat menggunakan akun:
                <br>• Admin: <code>admin</code> / <code>admin123</code>
                <br>• Nasabah: <code>budi</code> / <code>password123</code>
            </div>
        <?php else: ?>
            <div class="banner failed">
                ❌ Setup gagal. Pastikan modul MySQL di XAMPP Control Panel sudah AKTIF (Start).
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
