{{-- @extends('layouts.app') --}}

{{-- @section('content') --}}
<h2>Daftar Produk</h2>

<a href="{{ route('admin.produk.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($produk as $p)
            <tr>
                <td>{{ $p->idbarang }}</td>
                <td>{{ $p->nama_barang }}</td>
                <td>{{ number_format($p->harga) }}</td>
                <td>{{ $p->status }}</td>
                <td>{{ $p->stok }}</td>
                <td>
                    <a href="{{ route('admin.produk.show', $p->idbarang) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('admin.produk.edit', $p->idbarang) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.produk.destroy', $p->idbarang) }}"
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{-- @endsection --}}
