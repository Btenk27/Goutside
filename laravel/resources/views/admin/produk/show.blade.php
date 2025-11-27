{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}

<h2>Detail Produk</h2>

<p><strong>Nama:</strong> {{ $produk->nama_barang }}</p>
<p><strong>Harga:</strong> {{ number_format($produk->harga) }}</p>
<p><strong>Deskripsi:</strong> {{ $produk->deskripsi }}</p>
<p><strong>Spesifikasi:</strong> {{ $produk->spesifikasi }}</p>
<p><strong>Status:</strong> {{ $produk->status }}</p>
<p><strong>Stok:</strong> {{ $produk->stok }}</p>
<p><strong>Kategori:</strong> {{ $produk->kategori }}</p>

@if ($produk->gambar)
    <p><img src="{{ asset('storage/'.$produk->gambar) }}" width="200"></p>
@endif

<a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">Kembali</a>

{{-- @endsection --}}

