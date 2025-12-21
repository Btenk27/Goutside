<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReservationItem extends Model
{
    use HasFactory;

    protected $table = 'reservation_items';

    protected $fillable = [
    'reservation_id',
    'produk_id',
    'produk_nama',
    'produk_kategori',
    'harga_satuan',
    'qty',
    'subtotal',
];


    // relasi
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'idbarang');
    }
}
