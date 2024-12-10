<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AccountSeeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AccountSeeder::class
        ]);

        // Hapus data yang ada
        DB::table('users')->truncate();
        
        // Insert users
        DB::table('users')->insert([
            [
                'nama' => 'admin',
                'username' => 'admin',
                'password' => md5('admin123'),
                'role' => 'admin'
            ],
            [
                'nama' => 'user',
                'username' => 'user',
                'password' => md5('user123'),
                'role' => 'user'
            ]
        ]);
    }
}
