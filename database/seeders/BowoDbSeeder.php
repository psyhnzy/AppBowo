<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BowoDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Initial Data Users
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Administrator BOWO',
                'username' => 'admin',
                'email' => 'admin@bowo.id',
                'phone' => '081234567890',
                'address' => 'Kantor Pusat BOWO',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'balance' => 0.00,
                'points' => 0,
                'status' => 'active',
            ],
            [
                'id' => 2,
                'name' => 'Budi Santoso',
                'username' => 'budi',
                'email' => 'budi@gmail.com',
                'phone' => '081298765432',
                'address' => 'Jl. Merdeka No. 12',
                'password' => Hash::make('password123'),
                'role' => 'nasabah',
                'balance' => 25000.00,
                'points' => 50,
                'status' => 'active',
            ],
            [
                'id' => 3,
                'name' => 'Siti Rahma',
                'username' => 'siti',
                'email' => 'siti@gmail.com',
                'phone' => '085612345678',
                'address' => 'Jl. Mawar No. 5',
                'password' => Hash::make('password123'),
                'role' => 'nasabah',
                'balance' => 40000.00,
                'points' => 80,
                'status' => 'active',
            ],
        ]);

        // 2. Initial Data Waste Types
        DB::table('waste_types')->insert([
            [
                'id' => 1,
                'name' => 'Plastik PET (Botol Bening)',
                'category' => 'Plastik',
                'price_per_kg' => 5000.00,
                'description' => 'Botol air mineral bekas bersih tanpa label',
                'status' => 'active',
            ],
            [
                'id' => 2,
                'name' => 'Kertas Dupleks / Dus',
                'category' => 'Kardus',
                'price_per_kg' => 2500.00,
                'description' => 'Kardus bekas kemasan, bersih dan kering',
                'status' => 'active',
            ],
            [
                'id' => 3,
                'name' => 'Kertas HVS / Buku',
                'category' => 'Kertas',
                'price_per_kg' => 3000.00,
                'description' => 'Kertas putih bekas cetak atau buku tulis',
                'status' => 'active',
            ],
            [
                'id' => 4,
                'name' => 'Kaleng / Besi Tipis',
                'category' => 'Logam',
                'price_per_kg' => 8000.00,
                'description' => 'Kaleng minuman atau wadah makanan logam',
                'status' => 'active',
            ],
        ]);

        // 3. Initial Data Targets
        DB::table('targets')->insert([
            [
                'id' => 1,
                'user_id' => 2,
                'target_weight' => 10.00,
                'period' => 'Bulan Ini',
            ],
            [
                'id' => 2,
                'user_id' => 3,
                'target_weight' => 15.00,
                'period' => 'Bulan Ini',
            ],
        ]);
    }
}
