<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'reservation_code', // Ini yang dipakai sebagai order_id Midtrans
        'start_date',
        'end_date',
        'grand_total',
        'status',           // Status reservasi
        'payment_status',   // Status pembayaran
        'payment_method',
        'payment_token',
    ];
    
    // Scope untuk status pembayaran
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }
    
    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'unpaid');
    }
    
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }
}