{{-- @extends('layouts.app')

@section('content') --}}
<h2>Edit Produk</h2>

<form action="{{ route('admin.produk.update', $produk->idbarang) }}" 
      method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    @include('produk.form')

    <button class="btn btn-primary">Update</button>
</form>
{{-- @endsection --}}
