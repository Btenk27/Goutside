<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'idbarang';

    protected $fillable = [
        'nama_barang',
        'harga',
        'gambar',
        'deskripsi',
        'spesifikasi',
        'status',
        'stok',
        'kategori',
    ];
}
