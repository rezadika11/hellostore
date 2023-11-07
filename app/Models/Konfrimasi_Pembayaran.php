<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konfrimasi_Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'konfirmasi_pembayaran';
    protected $primaryKey = 'id_konfirmasi_pembayaran';
    protected $guarded = [''];
}
