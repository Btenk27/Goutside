<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ReservasiController;
use App\Models\Produk;
use App\Models\Reservasi;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik sederhana
        $totalProduk      = Produk::count();
        $totalReservasi   = Reservasi::count();
        $pendingReservasi = Reservasi::where('status', 'pending')->count();
        $approvedReservasi = Reservasi::where('status', 'approved')->count();

        // Reservasi terbaru (5 terakhir)
        $latestReservations = Reservasi::with('produk', 'user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProduk',
            'totalReservasi',
            'pendingReservasi',
            'approvedReservasi',
            'latestReservations'
        ));
    }
}
