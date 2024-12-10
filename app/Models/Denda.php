<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'denda';
    protected $primaryKey = 'id_denda';
    
    protected $fillable = [
        'id_peminjaman',
        'tanggal_denda',
        'jumlah_hari',
        'jumlah_denda',
        'status'
    ];

    protected $dates = [
        'tanggal_denda'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}

