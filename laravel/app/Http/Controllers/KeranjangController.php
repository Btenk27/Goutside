<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    
    public function index()
    {
        $keranjang = Keranjang::with('items.produk')
            ->where('user_id', Auth::id())
            ->where('status', 'aktif')
            ->first();

        return view('keranjang.index', compact('keranjang'));
    }

    /**
     * Tambah produk ke keranjang (dari katalog)
     * ❗ DIBATASI STOK
     */
    public function store(Request $request)
    {

        $produk = Produk::findOrFail($request->produk_id);
if($produk->stok < $request->qty){
    return back()->with('error', 'Stok tidak mencukupi');
}

        $request->validate([
            'produk_id' => 'required|exists:produk,idbarang',
            'qty'       => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        $keranjang = Keranjang::firstOrCreate([
            'user_id' => Auth::id(),
            'status'  => 'aktif',
        ]);

        $item = KeranjangItem::where('keranjang_id', $keranjang->id)
            ->where('produk_id', $produk->idbarang)
            ->first();

        $qtyDiKeranjang = $item ? $item->qty : 0;
        $qtyBaru = $qtyDiKeranjang + $request->qty;

        // ❌ JIKA MELEBIHI STOK
        if ($qtyBaru > $produk->stok) {
            return back()->with('error', 'Stok produk tidak mencukupi');
        }

        if ($item) {
            $item->increment('qty', $request->qty);
        } else {
            KeranjangItem::create([
                'keranjang_id' => $keranjang->id,
                'produk_id'    => $produk->idbarang,
                'qty'          => $request->qty,
                'harga_satuan' => $produk->harga,
            ]);
        }

        return redirect()
            ->route('keranjang.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    /**
     * Tambah qty (+)
     * ❗ DIBATASI STOK
     */
    public function increaseQty($itemId)
    {
        $item = KeranjangItem::with('produk')
            ->where('id', $itemId)
            ->whereHas('keranjang', function ($q) {
                $q->where('user_id', Auth::id())
                  ->where('status', 'aktif');
            })
            ->firstOrFail();

        // ❌ JIKA QTY SUDAH = STOK
        if ($item->qty >= $item->produk->stok) {
            return back()->with('error', 'Stok produk sudah habis');
        }

        $item->increment('qty');

        return back();
    }

    /**
     * Kurangi qty (-)
     */
    public function decreaseQty($itemId)
    {
        $item = KeranjangItem::where('id', $itemId)
            ->whereHas('keranjang', function ($q) {
                $q->where('user_id', Auth::id())
                  ->where('status', 'aktif');
            })
            ->firstOrFail();

        if ($item->qty > 1) {
            $item->decrement('qty');
        } else {
            $item->delete();
        }

        return back();
    }
    public function hapus($id)
{
    $item = KeranjangItem::findOrFail($id);
    $item->delete();

    return back()->with('success', 'Item berhasil dihapus dari keranjang');
}

public function minus($id)
{
    $item = KeranjangItem::findOrFail($id);
    if($item->qty > 1){
        $item->decrement('qty', 1);
    } else {
        $item->delete();
    }
    return back();
}

public function plus($id)
{
    $item = KeranjangItem::findOrFail($id);
    if($item->qty < $item->produk->stok){
        $item->increment('qty', 1);
    }
    return back();
}


}