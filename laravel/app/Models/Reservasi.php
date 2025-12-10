<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservations';
        
    protected $fillable = [
        'user_id',
        'produk_id',
        'start_date',
        'end_date',
        'qty',
        'total_price',
        'status',
        'reservation_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'idbarang');
    }
}
