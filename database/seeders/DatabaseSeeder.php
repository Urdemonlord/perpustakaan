<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AccountSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Nonaktifkan foreign key checks
        Schema::disableForeignKeyConstraints();
        
        // Truncate semua tabel yang perlu di-reset
        DB::table('users')->truncate();
        DB::table('kategori')->truncate();
        DB::table('buku')->truncate();
        DB::table('anggota')->truncate();
        DB::table('peminjaman')->truncate();
        DB::table('denda')->truncate();
        
        // Aktifkan kembali foreign key checks
        Schema::enableForeignKeyConstraints();

        // Panggil seeder lainnya
        $this->call([
            AccountSeeder::class
        ]);
    }
}
