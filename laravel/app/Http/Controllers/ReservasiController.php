<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ReservasiController extends Controller
{
    // Form reservasi
    public function create($id = null)
    {
        $item = $id ? Produk::find($id) : null;
        return view('reservasi.create', compact('item'));
    }

    // Proses simpan reservasi
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'qty' => 'required|integer|min:1',
        ]);

         $item = Produk::findOrFail($request->item_id);

          // hitung durasi (minimal 1 hari)
         $days = (strtotime($request->end_date) - strtotime($request->start_date)) / 86400 + 1;
         if ($days < 1) {
            $days = 1;
    }

      // hitung total harga
    $total = $item->price_per_day * $days * $request->qty;

        $item = Produk::findOrFail($request->item_id);
        $days = (strtotime($request->end_date) - strtotime($request->start_date)) / 86400 + 1;
        $total = $item->price_per_day * $days * $request->qty;

        Reservation::create([
            'user_id' => auth()->id ?? 1, // user dummy
            'item_id' => $item->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'qty' => $request->qty,
            'total_price' => $total,
            'reservation_code' => strtoupper(Str::random(8)),
            'status' => 'pending',
        ]);

        return redirect()->route('katalog.index')->with('success', 'Reservasi berhasil dikirim!');
    }
}
