<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 antialiased">

    @include('partial.navbar')

    <main class="max-w-4xl mx-auto px-4 py-8">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">Tambah Produk</h1>
        <p class="text-sm text-slate-400">
            Tambahkan perlengkapan hiking baru ke katalog.
        </p>
    </div>

    <div class="flex gap-2">
        {{-- Tombol lihat produk --}}
        <a href="{{ route('admin.produk.index') }}"
            class="text-sm text-slate-200 border border-slate-600 px-3 py-1.5 rounded-lg hover:bg-slate-800">
            Lihat Produk
        </a>

        {{-- Tombol kembali ke dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
            class="text-sm text-white bg-emerald-600 px-3 py-1.5 rounded-lg hover:bg-emerald-700">
            Kembali ke Dashboard
        </a>
    </div>
</div>

        {{-- Error --}}
        @if ($errors->any())
            <div class="mb-4 rounded-xl bg-red-500/10 border border-red-500/50 px-4 py-3 text-sm text-red-200">
                <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form --}}
        <div class="bg-slate-900/70 border border-slate-800 rounded-2xl p-6 shadow-xl">
            <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data"
                class="space-y-5">
                @csrf

                {{-- Nama Barang --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Barang</label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                        class="w-full rounded-lg border border-slate-700 bg-slate-950/40 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                        required>
                </div>

                {{-- Harga --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Harga per Hari (Rp)</label>
                    <input type="number" name="harga" value="{{ old('harga') }}"
                        class="w-full rounded-lg border border-slate-700 bg-slate-950/40 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                        min="0" step="1000" required>
                </div>

                {{-- Gambar --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Gambar Produk</label>
                    <input type="file" name="gambar"
                        class="w-full text-sm text-slate-200 file:mr-4 file:rounded-md file:border-0 file:bg-emerald-600 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-emerald-700">
                    <p class="mt-1 text-xs text-slate-400">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full rounded-lg border border-slate-700 bg-slate-950/40 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('deskripsi') }}</textarea>
                </div>

                {{-- Spesifikasi --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Spesifikasi (opsional)</label>
                    <textarea name="spesifikasi" rows="3"
                        class="w-full rounded-lg border border-slate-700 bg-slate-950/40 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('spesifikasi') }}</textarea>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Status</label>
                        <select name="status"
                            class="w-full rounded-lg border border-slate-700 bg-slate-950/40 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                            required>
                            <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>Tersedia
                            </option>
                            <option value="Tidak tersedia" {{ old('status') == 'Tidak tersedia' ? 'selected' : '' }}>
                                Tidak tersedia</option>
                        </select>
                    </div>

                    {{-- Stok --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', 0) }}"
                            class="w-full rounded-lg border border-slate-700 bg-slate-950/40 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500"
                            min="0" required>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Kategori</label>
                        <select name="kategori"
                            class="w-full rounded-lg border border-slate-700 bg-slate-950/40 px-3 py-2 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Tenda" {{ old('kategori') == 'Tenda' ? 'selected' : '' }}>Tenda</option>
                            <option value="Carrier" {{ old('kategori') == 'Carrier' ? 'selected' : '' }}>Carrier</option>
                            <option value="Alat Masak" {{ old('kategori') == 'Alat Masak' ? 'selected' : '' }}>Alat Masak</option>
                            <option value="Elektronik" {{ old('kategori') == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                            <option value="Peralatan Pribadi" {{ old('kategori') == 'Peralatan Pribadi' ? 'selected' : '' }}>Peralatan Pribadi</option>
                            <option value="Survival" {{ old('kategori') == 'Survival' ? 'selected' : '' }}>Survival</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <a href="{{ route('admin.produk.index') }}"
                        class="px-4 py-2 rounded-lg border border-slate-700 text-sm text-slate-200 hover:bg-slate-800">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-emerald-600 text-sm font-semibold text-white hover:bg-emerald-700">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>