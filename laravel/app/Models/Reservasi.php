<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'start_date',
        'end_date',
        'qty',
        'total_price',
        'reservation_code',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Item
    public function item()
    {
        return $this->belongsTo(Produk::class);
    }
}
