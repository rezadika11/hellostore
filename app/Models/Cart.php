<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $primaryKey = 'id_id_cart';
    protected $fillable = ['id_user', 'id_produk', 'quantity', 'harga'];

    public function  produk()
    {
        return $this->hasMany(Produk::class, 'id_produk');
    }
}
