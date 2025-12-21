<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #ffffff;
            color: #1e293b;
        }

        .card {
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .btn-primary {
            background: linear-gradient(90deg, #10b981, #22d3ee);
            color: white;
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #22d3ee, #10b981);
        }

        .btn-secondary {
            border-radius: 0.75rem;
            border: 1px solid #cbd5e1;
            padding: 0.5rem 1rem;
            color: #1e293b;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background-color: #f1f5f9;
        }

        input, textarea, select {
            background-color: #f8fafc;
            border-radius: 0.5rem;
            border: 1px solid #cbd5e1;
            padding: 0.5rem;
            width: 100%;
            transition: all 0.2s;
        }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 2px rgba(16,185,129,0.2);
        }

        img.product-image {
            margin-top: 0.5rem;
            border-radius: 0.5rem;
            max-height: 150px;
        }
    </style>
</head>
<body class="antialiased">

@include('partial.navbar')

<main class="max-w-4xl mx-auto px-4 py-8 space-y-6">

    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Edit Produk</h1>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.produk.index') }}" class="btn-primary text-sm">Kembali ke Daftar Produk</a>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary text-sm">Dashboard</a>
        </div>
    </header>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-100 border border-red-300 px-4 py-3 text-sm text-red-700">
            <p class="font-semibold mb-1">Terjadi kesalahan:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <form action="{{ route('admin.produk.update', $produk->idbarang) }}" 
              method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Nama Barang</label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang', $produk->nama_barang) }}" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Harga per Hari (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" min="0" step="1000" required>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Gambar Produk</label>
                <input type="file" name="gambar">
                @if ($produk->gambar)
                    <p class="mt-1 text-sm text-gray-500">Gambar saat ini: {{ $produk->gambar }}</p>
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="Gambar Produk" class="product-image">
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Spesifikasi (opsional)</label>
                <textarea name="spesifikasi" rows="3">{{ old('spesifikasi', $produk->spesifikasi) }}</textarea>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="status" required>
                        <option value="Tersedia" {{ old('status', $produk->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Tidak tersedia" {{ old('status', $produk->status) == 'Tidak tersedia' ? 'selected' : '' }}>Tidak tersedia</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Stok</label>
                    <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" min="0" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Kategori</label>
                    <select name="kategori">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Tenda" {{ old('kategori', $produk->kategori) == 'Tenda' ? 'selected' : '' }}>Tenda</option>
                        <option value="Carrier" {{ old('kategori', $produk->kategori) == 'Carrier' ? 'selected' : '' }}>Carrier</option>
                        <option value="Alat Masak" {{ old('kategori', $produk->kategori) == 'Alat Masak' ? 'selected' : '' }}>Alat Masak</option>
                        <option value="Elektronik" {{ old('kategori', $produk->kategori) == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                        <option value="Peralatan Pribadi" {{ old('kategori', $produk->kategori) == 'Peralatan Pribadi' ? 'selected' : '' }}>Peralatan Pribadi</option>
                        <option value="Survival" {{ old('kategori', $produk->kategori) == 'Survival' ? 'selected' : '' }}>Survival</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <a href="{{ route('admin.produk.index') }}" class="btn-secondary text-sm">Batal</a>
                <button type="submit" class="btn-primary text-sm">Update Produk</button>
            </div>
        </form>
    </div>

</main>
</body>
</html>
