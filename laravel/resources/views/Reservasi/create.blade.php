<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Barang - Goutside</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">

    @includeIf('partial.navbar')

    <main class="max-w-xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold mb-4 text-center">Form Reservasi</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('reservasi.store') }}" class="bg-white p-6 rounded-xl shadow space-y-4">
            @csrf

            {{-- PILIH PRODUK --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Produk</label>
                <select name="produk_id"
                        class="w-full border rounded-lg px-3 py-2 text-sm"
                        required>
                    <option value="">-- Pilih perlengkapan --</option>
                    @foreach($produkList as $p)
                        <option value="{{ $p->idbarang }}"
                            @selected(old('produk_id', $selectedProduk->idbarang ?? null) == $p->idbarang)>
                            {{ $p->nama_barang }} - Rp {{ number_format($p->harga, 0, ',', '.') }}/hari
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TANGGAL MULAI --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ old('start_date') }}"
                       class="w-full border rounded-lg px-3 py-2 text-sm" required>
            </div>

            {{-- TANGGAL SELESAI --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" value="{{ old('end_date') }}"
                       class="w-full border rounded-lg px-3 py-2 text-sm" required>
            </div>

            {{-- QTY --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (qty)</label>
                <input type="number" name="qty" min="1" value="{{ old('qty', 1) }}"
                       class="w-full border rounded-lg px-3 py-2 text-sm" required>
            </div>

            <button type="submit"
                    class="w-full bg-emerald-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-emerald-700">
                Kirim Reservasi
            </button>
        </form>
    </main>

</body>
</html>
