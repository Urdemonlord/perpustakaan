<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
    
    protected $fillable = [
        'kode_peminjaman',
        'tanggal_pinjam',
        'tanggal_kembali',
        'id_anggota',
        'id_buku',
        'status'
    ];

    protected $dates = [
        'tanggal_pinjam',
        'tanggal_kembali'
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    public function denda()
    {
        return $this->hasOne(Denda::class, 'id_peminjaman');
    }
}
