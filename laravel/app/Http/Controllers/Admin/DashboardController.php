<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Reservation;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik
        $totalProduk        = Produk::count();
        $totalReservasi     = Reservation::count();
        $pendingReservasi   = Reservation::where('status', 'pending')->count();
        $approvedReservasi  = Reservation::where('status', 'approved')->count();
        $selesaiReservasi   = Reservation::where('status', 'selesai')->count();

        // Reservasi terbaru (5 terakhir)
        $latestReservations = Reservation::with(['items', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalReservasi',
            'pendingReservasi',
            'approvedReservasi',
            'selesaiReservasi',
            'latestReservations'
        ));
    }
}
