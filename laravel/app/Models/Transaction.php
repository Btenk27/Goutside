<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi (fillable)
     * ⚠️ PASTIKAN ADA KOLOM-KOLOM INI:
     */
    protected $fillable = [
        'user_id',           // ID user yang melakukan transaksi
        'order_id',          // Order ID untuk Midtrans (unik)
        'snap_token',        // Token dari Midtrans Snap
        'gross_amount',      // Jumlah pembayaran
        'payment_type',      // Jenis pembayaran (credit_card, bank_transfer, etc)
        'transaction_status',// Status dari Midtrans (pending, settlement, etc)
        'status',            // Status di sistem kita (pending, success, failed)
        'payment_status',    // Status pembayaran (unpaid, paid, expired)
        'transaction_time',  // Waktu transaksi
        'fraud_status',      // Status fraud dari Midtrans
        'pdf_url',           // URL bukti pembayaran (jika ada)
        'metadata',          // Data tambahan (json)
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'metadata' => 'array',
        'gross_amount' => 'integer',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk status pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk status success
     */
    public function scopeSuccess($query)
    {
        return $query->where('status', 'success');
    }

    /**
     * Cek apakah transaksi sudah sukses
     */
    public function isSuccess()
    {
        return $this->status === 'success';
    }

    /**
     * Cek apakah transaksi masih pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Update status berdasarkan notifikasi Midtrans
     */
    public function updateFromMidtrans($notification)
    {
        $status = $notification->transaction_status;
        
        $this->transaction_status = $status;
        
        // Mapping status Midtrans ke status sistem kita
        $statusMap = [
            'capture' => 'success',
            'settlement' => 'success',
            'pending' => 'pending',
            'deny' => 'failed',
            'expire' => 'expired',
            'cancel' => 'canceled'
        ];
        
        $this->status = $statusMap[$status] ?? 'pending';
        $this->payment_status = ($this->status === 'success') ? 'paid' : 'unpaid';
        
        if (isset($notification->fraud_status)) {
            $this->fraud_status = $notification->fraud_status;
        }
        
        $this->save();
        
        return $this;
    }
}