<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;

    protected $table = 'tb_petugas'; // Nama tabel
    protected $primaryKey = 'id_petugas'; // Kunci utama

    // Tentukan atribut yang dapat diisi
    protected $fillable = ['nama_petugas', 'username', 'password', 'level', 'status_petugas'];

    // Menyembunyikan password agar tidak tampil pada response
    protected $hidden = ['password'];
}
