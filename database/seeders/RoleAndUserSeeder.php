<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT DATA ROLE (PERAN) TERLEBIH DAHULU
        // Ini wajib agar foreign key role_id di tabel users tidak error
        $roles = [
            ['id' => 1, 'name' => 'Pustakawan', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Kepala Sekolah', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Admin IT', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['id' => $role['id']], 
                $role
            );
        }

        // 2. BUAT DATA USER SETELAH ROLE TERSEDIA
        $users = [
            [
                'name' => 'Admin IT Sekolah',
                'email' => 'it@mtsn1majene.com',
                'password' => Hash::make('12345678'), 
                'role_id' => 3, // Merujuk ke role_id = 3 (Admin IT)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kepala Sekolah',
                'email' => 'kepsek@mtsn1majene.com',
                'password' => Hash::make('12345678'), 
                'role_id' => 2, // Merujuk ke role_id = 2 (Kepala Sekolah)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staf Pustakawan Utama',
                'email' => 'pustakawan@mtsn1majene.com',
                'password' => Hash::make('12345678'), 
                'role_id' => 1, // Merujuk ke role_id = 1 (Pustakawan)
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']], 
                $user
            );
        }
    }
}