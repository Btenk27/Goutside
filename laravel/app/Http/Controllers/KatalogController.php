<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        // Daftar kategori dasar
        $kategoriDasar = [
            'Tenda',
            'Carrier', 
            'Alat Masak',
            'Elektronik',
            'Peralatan Pribadi',
            'Survival'
        ];
        
        // Ambil kategori dari produk yang sudah ada
        $kategoriDariDatabase = Produk::select('kategori')
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->pluck('kategori')
            ->toArray();
        
        // Gabungkan, hapus duplikat, urutkan
        $semuaKategori = array_unique(array_merge($kategoriDasar, $kategoriDariDatabase));
        sort($semuaKategori);
        
        // Query produk
        $query = Produk::query();

        // Produk hanya yang stok > 0 dan status Tersedia
        $query->where('status', 'Tersedia')->where('stok', '>', 0);

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $items = $query->paginate(12)->withQueryString();

        // Hitung jumlah produk per kategori (stok > 0 & status Tersedia)
        $jumlahPerKategori = [];
        foreach ($semuaKategori as $kategori) {
            $jumlahPerKategori[$kategori] = Produk::where('kategori', $kategori)
                ->where('status', 'Tersedia')
                ->where('stok', '>', 0)
                ->count();
        }

        return view('katalog.index', [
            'items' => $items,
            'semuaKategori' => $semuaKategori,        
            'jumlahPerKategori' => $jumlahPerKategori,   
            'kategoriDipilih' => $request->kategori
        ]);
    }
    
    public function show($id)
    {
        $item = Produk::findOrFail($id);
        return view('katalog.show', compact('item'));
    }

    // Endpoint untuk polling stok agar front-end bisa update real-time
    public function stok()
    {
        $produk = Produk::select('idbarang', 'stok', 'status')->get();
        return response()->json($produk);
    }
}
