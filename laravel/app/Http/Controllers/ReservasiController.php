<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class ReservasiController extends Controller
{
    public function create($idbarang = null)
    {
        // semua produk yang bisa dipilih
        $produkList = Produk::where('status', 'Tersedia')
                            ->where('stok', '>', 0)
                            ->get();

        // kalau datang dari katalog
        $selectedProduk = null;
        if ($idbarang) {
            $selectedProduk = Produk::find($idbarang);
        }

        return view('reservasi.create', [
            'produkList'     => $produkList,
            'selectedProduk' => $selectedProduk,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id'  => 'required|exists:produk,idbarang',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'qty'        => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        $start = strtotime($request->start_date);
        $end   = strtotime($request->end_date);
        $days  = (int) round(($end - $start) / 86400) + 1;
        if ($days < 1) {
            $days = 1;
        }

        $total = $produk->harga * $days * $request->qty;

        $userId = Auth::check() ? Auth::user()->id : null;


        Reservation::create([
            'user_id'          => $userId,
            'produk_id'        => $produk->idbarang,
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'qty'              => $request->qty,
            'total_price'      => $total,
            'reservation_code' => strtoupper(Str::random(8)),
            'status'           => 'pending',
        ]);

        return redirect()
            ->route('katalog.index')
            ->with('success', 'Reservasi berhasil dikirim, tunggu konfirmasi admin.');
    }
}
