<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $fillable = [
        'id_user',
        'id_produk',
        'name',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'alamat',
        'kode_pos',
        'no_hp',
        'gambar'
    ];
}
