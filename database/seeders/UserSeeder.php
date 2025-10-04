<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. ADMIN USER (role_id: 1)
        User::create([
            'role_id' => 1, // admin
            'name' => 'Admin Buds Studio',
            'email' => 'admin@budsstudio.com',
            'password' => Hash::make('password123'),
            'phone' => '081234567890',
            'address' => 'Jalan Merdeka No. 1, Jakarta Pusat, Indonesia',
        ]);

        // 2. CUSTOMER USERS (role_id: 2)
        $customers = [
            // Customer 1
            [
                'name' => 'Sayida Syahira',
                'email' => 'sayida@example.com',
                'phone' => '089876543210',
                'address' => 'Jalan Sudirman No. 5, Bandung, Jawa Barat',
            ],
            // Customer 2
            [
                'name' => 'Rizky Pratama',
                'email' => 'rizky.pratama@example.com',
                'phone' => '085611223344',
                'address' => 'Komplek Griya Indah Blok C10, Surabaya, Jawa Timur',
            ],
            // Customer 3
            [
                'name' => 'Citra Dewi',
                'email' => 'citradewi@example.com',
                'phone' => '081399887766',
                'address' => 'Jalan Kartini Raya No. 15, Medan, Sumatera Utara',
            ],
            // Customer 4
            [
                'name' => 'Bima Sakti',
                'email' => 'bimasakti@example.com',
                'phone' => '087755443322',
                'address' => 'Perumahan Damai Sentosa No. 45, Semarang, Jawa Tengah',
            ],
            // Customer 5
            [
                'name' => 'Aisha Putri',
                'email' => 'aishaputri@example.com',
                'phone' => '081900112233',
                'address' => 'Jalan Pahlawan No. 20, Yogyakarta, DIY',
            ],
            // Customer 6
            [
                'name' => 'Fajar Nugraha',
                'email' => 'fajar.nugraha@example.com',
                'phone' => '082266778899',
                'address' => 'Gatot Subroto No. 3A, Denpasar, Bali',
            ],
            // Customer 7
            [
                'name' => 'Lina Maria',
                'email' => 'lina.maria@example.com',
                'phone' => '085710293847',
                'address' => 'Komplek Harapan Jaya, Pekanbaru, Riau',
            ],
            // Customer 8
            [
                'name' => 'Dian Setiawan',
                'email' => 'dian.setiawan@example.com',
                'phone' => '081199008877',
                'address' => 'Jalan Kembang Sepatu No. 11, Makassar, Sulawesi Selatan',
            ],
            // Customer 9
            [
                'name' => 'Wulan Sari',
                'email' => 'wulan.sari@example.com',
                'phone' => '083844556677',
                'address' => 'Ruko Emerald B-7, Balikpapan, Kalimantan Timur',
            ],
        ];

        foreach ($customers as $customer) {
            User::create([
                'role_id' => 2, // customer
                'name' => $customer['name'],
                'email' => $customer['email'],
                'password' => Hash::make('password123'),
                'phone' => $customer['phone'],
                'address' => $customer['address'],
            ]);
        }
    }
}