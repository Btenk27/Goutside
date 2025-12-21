<?php

namespace App\Http\Controllers;

use App\Models\KeranjangItem;
use App\Models\Reservation;
use App\Models\ReservationItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('reservasi.index', compact('reservations'));
    }

    public function storeFromKeranjang(Request $request)
    {
        $request->validate([
            'items'      => 'required|array|min:1',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        DB::transaction(function () use ($request) {

            $items = KeranjangItem::with('produk')
                ->whereIn('id', $request->items)
                ->get();

            $days = (strtotime($request->end_date) - strtotime($request->start_date)) / 86400 + 1;

            $grandTotal = 0;
            foreach ($items as $item) {
                $grandTotal += $item->harga_satuan * $item->qty * $days;
            }

            $reservation = Reservation::create([
                'user_id'          => Auth::id(),
                'reservation_code' => strtoupper(Str::random(8)),
                'start_date'       => $request->start_date,
                'end_date'         => $request->end_date,
                'grand_total'      => $grandTotal,
                'status'           => 'pending',
            ]);

            foreach ($items as $item) {
                $subtotal = $item->harga_satuan * $item->qty * $days;

                ReservationItem::create([
                    'reservation_id'  => $reservation->id,
                    'produk_id'       => $item->produk->idbarang,
                    'produk_nama'     => $item->produk->nama_barang,
                    'produk_kategori' => $item->produk->kategori,
                    'harga_satuan'    => $item->harga_satuan,
                    'qty'             => $item->qty,
                    'subtotal'        => $subtotal,
                ]);
            }

            KeranjangItem::whereIn('id', $request->items)->delete();
        });

        return redirect()
            ->route('reservasi.index')
            ->with('success', 'Reservasi berhasil dibuat');
    }

    public function updateStatus(Request $request, $id)
{
    $reservation = Reservation::findOrFail($id);

    // Simpan langsung status dari request
    $reservation->status = $request->input('status');
    $reservation->save();

    return back()->with('success', 'Status reservasi berhasil diperbarui.');

    
}




}
