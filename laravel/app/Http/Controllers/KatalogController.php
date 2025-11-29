<?php

namespace App\Http\Controllers;

use App\Models\Item; // pastikan kamu sudah punya model Item
use App\Models\Produk;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    // Halaman katalog untuk customer
    public function index()
    {
        // ambil semua item aktif, bisa disesuaikan
        $items = Produk::latest()->paginate(12);

        return view('katalog.index', compact('items'));
    }

    // Halaman detail barang
    public function show($id)
    {
        $item = Produk::findOrFail($id);

        return view('katalog.show', compact('item'));
    }
}
