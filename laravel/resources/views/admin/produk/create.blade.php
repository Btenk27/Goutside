{{-- @extends('layouts.app')

@section('content') --}}
<h2>Tambah Produk</h2>

<form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    @include('admin.produk.form')

    <button class="btn btn-primary">Simpan</button>
</form>
{{-- @endsection --}}
