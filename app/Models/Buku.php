<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    
    protected $fillable = [
        'kode_buku',
        'id_kategori',
        'judul_buku',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'jumlah_buku'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}

