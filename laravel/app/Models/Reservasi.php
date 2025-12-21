<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'reservation_code',
        'start_date',
        'end_date',
        'grand_total',
        'status',
    ];

    //  RELASI KE USER 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //  RELASI KE ITEM
    public function items()
    {
        return $this->hasMany(ReservationItem::class, 'reservation_id');
    }
}
