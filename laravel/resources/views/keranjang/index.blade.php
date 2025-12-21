<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya - Goutside</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .fade-up {
            opacity: 0;
            transform: translateY(18px);
            transition: all .6s ease;
        }
        .fade-up.show {
            opacity: 1;
            transform: translateY(0);
        }

        .card-hover:hover {
            box-shadow:
                0 20px 40px rgba(16,185,129,.15),
                inset 0 0 0 1px rgba(255,255,255,.35);
        }
    </style>
</head>

<body class="bg-gradient-to-b from-slate-50 via-white to-slate-100 text-gray-900">

@includeIf('partial.navbar')

<main class="max-w-6xl mx-auto px-4 py-12 relative">

    {{-- AMBIENT --}}
    <div class="absolute -top-40 -right-40 w-[420px] h-[420px]
    bg-emerald-300/20 rounded-full blur-[140px]"></div>

    {{-- HEADER --}}
    <div class="relative mb-10 fade-up">
        <h1 class="text-3xl md:text-4xl font-bold tracking-tight">
            Keranjang Saya
        </h1>
        <p class="text-gray-500 text-sm mt-2">
            Periksa kembali perlengkapan sebelum menyewa
        </p>
    </div>

    {{-- EMPTY --}}
    @if(!$keranjang || $keranjang->items->count() == 0)
        <div class="fade-up bg-white/80 backdrop-blur
        rounded-3xl p-14 shadow text-center card-hover">

            <p class="text-gray-500 text-lg mb-6">
                Keranjang kamu masih kosong
            </p>

            <a href="{{ route('katalog.index') }}"
               class="inline-flex items-center gap-2
               px-7 py-3 rounded-full
               bg-gradient-to-r from-emerald-600 to-cyan-500
               text-white font-semibold
               hover:brightness-110 transition">
                Mulai Belanja
            </a>
        </div>

    @else

    {{-- LIST ITEM --}}
    <div class="grid gap-6 mb-10 relative">
        @foreach($keranjang->items as $item)
            <div class="fade-up bg-white/75 backdrop-blur
            rounded-3xl p-6 shadow card-hover transition">

                <div class="flex flex-col md:flex-row md:items-center
                md:justify-between gap-6">

                    {{-- INFO --}}
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">
                            Produk
                        </p>
                        <h3 class="text-lg font-semibold">
                            {{ $item->produk->nama_barang }}
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Harga:
                            <span class="font-medium text-gray-800">
                                Rp {{ number_format($item->harga_satuan,0,',','.') }}
                            </span>
                        </p>
                    </div>

                    {{-- QTY --}}
                    <div class="flex items-center gap-3">
                        <form action="{{ route('keranjang.minus', $item->id) }}" method="POST">
                            @csrf
                            <button class="w-8 h-8 rounded-full
                            bg-gray-100 hover:bg-gray-200 transition">
                                −
                            </button>
                        </form>

                        <span class="min-w-[24px] text-center font-semibold">
                            {{ $item->qty }}
                        </span>

                        <form action="{{ route('keranjang.plus', $item->id) }}" method="POST">
                            @csrf
                            <button class="w-8 h-8 rounded-full
                            bg-gray-100 hover:bg-gray-200 transition">
                                +
                            </button>
                        </form>
                    </div>

                    {{-- SUBTOTAL --}}
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Subtotal</p>
                        <p class="text-lg font-bold text-emerald-600">
                            Rp {{ number_format($item->harga_satuan * $item->qty,0,',','.') }}
                        </p>
                    </div>

                    {{-- DELETE --}}
                    <form action="{{ route('keranjang.hapus', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm px-4 py-2 rounded-full
                        bg-red-100 text-red-600
                        hover:bg-red-200 transition">
                            Hapus
                        </button>
                    </form>

                </div>
            </div>
        @endforeach
    </div>

    {{-- CHECKOUT --}}
    <form action="{{ route('reservasi.storeFromKeranjang') }}" method="POST" class="relative fade-up">
        @csrf

        <div class="bg-white/80 backdrop-blur
        rounded-3xl shadow p-8 card-hover">

            <h2 class="text-xl font-bold mb-6">
                Detail Penyewaan
            </h2>

            {{-- DATE --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                <div>
                    <label class="text-sm text-gray-600">Tanggal Mulai</label>
                    <input type="date" name="start_date" required
                    class="w-full mt-1 rounded-xl border-gray-300
                    focus:border-emerald-500 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Tanggal Selesai</label>
                    <input type="date" name="end_date" required
                    class="w-full mt-1 rounded-xl border-gray-300
                    focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>

            {{-- CHECKBOX --}}
            <div class="mb-6">
                <p class="font-semibold mb-3">
                    Produk yang disewa
                </p>
                <div class="grid gap-2">
                    @foreach($keranjang->items as $item)
                        <label class="flex items-center gap-3
                        bg-gray-50 px-4 py-2 rounded-xl">
                            <input type="checkbox" name="items[]"
                                   value="{{ $item->id }}"
                                   checked
                                   class="accent-emerald-600">
                            {{ $item->produk->nama_barang }}
                            <span class="text-xs text-gray-500">
                                (Qty {{ $item->qty }})
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- CTA --}}
            <button type="submit"
                class="w-full md:w-auto
                px-8 py-3 rounded-full
                bg-gradient-to-r from-emerald-600 to-cyan-500
                text-white font-semibold
                hover:brightness-110 transition">
                Checkout & Buat Reservasi
            </button>
        </div>
    </form>

    @endif
</main>

{{-- ANIMATION --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.fade-up')
        .forEach((el, i) =>
            setTimeout(() => el.classList.add('show'), i * 120)
        );
});
</script>

</body>
</html>
