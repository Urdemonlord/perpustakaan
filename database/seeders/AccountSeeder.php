<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'nama' => 'viki',
                'username' => '11111',
                'password' => md5('123'), // 123
                'role' => 'user'
            ],
            [
                'nama' => 'jovial',
                'username' => '12345',
                'password' => md5('123'), // 123
                'role' => 'user'
            ],
            [
                'nama' => 'admin',
                'username' => 'admin',
                'password' => md5('admin123'), // admin123
                'role' => 'admin'
            ]
        ]);
    }
} 