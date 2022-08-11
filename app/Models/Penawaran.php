<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_barang',
        'harga_penawaran',
        'stok_barang',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function penjualan()
    {
        return $this->hasOne(Penjualan::class, 'id_penawaran');
    }
    
}
