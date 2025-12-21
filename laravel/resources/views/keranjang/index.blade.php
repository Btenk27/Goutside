<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya - Goutside</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">

@includeIf('partial.navbar')

<main class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Keranjang Saya</h1>

    @if(!$keranjang || $keranjang->items->count() == 0)
        <div class="bg-white p-6 rounded-xl shadow text-center">
            <p class="text-gray-500">Keranjang masih kosong</p>
            <a href="{{ route('katalog.index') }}"
               class="inline-block mt-4 bg-emerald-600 text-white px-4 py-2 rounded-lg">
                Belanja Sekarang
            </a>
        </div>
    @else
        {{-- TABEL KERANJANG --}}
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="text-left py-2">Produk</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keranjang->items as $item)
                        <tr class="border-b">
                            <td class="py-2">{{ $item->produk->nama_barang }}</td>
                            <td class="text-center">Rp {{ number_format($item->harga_satuan,0,',','.') }}</td>
                            <td class="text-center">
                                <div class="flex justify-center items-center gap-2">
                                    {{-- Kurangi qty --}}
                                    <form action="{{ route('keranjang.minus', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">−</button>
                                    </form>

                                    <span class="min-w-[20px] text-center">{{ $item->qty }}</span>

                                    {{-- Tambah qty --}}
                                    <form action="{{ route('keranjang.plus', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">+</button>
                                    </form>
                                </div>
                            </td>
                            <td class="text-center font-semibold">
                                Rp {{ number_format($item->harga_satuan * $item->qty,0,',','.') }}
                            </td>
                            <td class="text-center">
                                {{-- Hapus item --}}
                                <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- FORM CHECKOUT --}}
        <form action="{{ route('reservasi.storeFromKeranjang') }}" method="POST">
            @csrf

            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="font-semibold mb-4">Tanggal Penyewaan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm">Tanggal Mulai</label>
                        <input type="date" name="start_date" required class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="text-sm">Tanggal Selesai</label>
                        <input type="date" name="end_date" required class="w-full border rounded-lg px-3 py-2">
                    </div>
                </div>

                {{-- Checkbox pilih item --}}
                <div class="mb-4">
                    <label class="font-semibold mb-2 block">Pilih Produk untuk Checkout:</label>
                    <div class="flex flex-col gap-2">
                        @foreach($keranjang->items as $item)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="items[]" value="{{ $item->id }}" class="accent-emerald-600" checked>
                                {{ $item->produk->nama_barang }} (Qty: {{ $item->qty }})
                            </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700">
                    Checkout dan Buat Reservasi
                </button>
            </div>
        </form>
    @endif
</main>

</body>
</html>
