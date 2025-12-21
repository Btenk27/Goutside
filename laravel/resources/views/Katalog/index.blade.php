<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Perlengkapan - Goutside</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen">

@includeIf('partial.navbar')

<main class="max-w-6xl mx-auto px-4 py-10 flex-grow">

    <h1 class="text-3xl font-bold mb-6">Katalog Perlengkapan</h1>

    {{-- FILTER --}}
    <div class="mb-8 bg-white/80 backdrop-blur rounded-2xl shadow p-4">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('katalog.index') }}"
               class="px-4 py-2 rounded-full text-sm font-medium
               {{ !request('kategori') ? 'bg-emerald-600 text-white shadow' : 'bg-gray-100 hover:bg-gray-200' }}">
                Semua
            </a>

            @foreach ($semuaKategori as $kategori)
                <a href="{{ route('katalog.index', ['kategori' => $kategori]) }}"
                   class="px-4 py-2 rounded-full text-sm font-medium
                   {{ request('kategori') == $kategori ? 'bg-emerald-600 text-white shadow' : 'bg-gray-100 hover:bg-gray-200' }}">
                    {{ $kategori }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- INFO --}}
    <div class="mb-6 text-sm text-gray-600">
        <span class="font-medium">{{ $items->total() }}</span> produk ditemukan
    </div>

    {{-- GRID --}}
    <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

        @forelse ($items as $item)
        <div class="bg-white rounded-2xl overflow-hidden product-card flex flex-col">

            <div class="product-image-container">
                @if ($item->gambar)
                    <img src="{{ asset('storage/'.$item->gambar) }}" class="object-contain h-full">
                @else
                    <span class="text-gray-400 text-sm">No Image</span>
                @endif
            </div>

            <div class="p-4 flex flex-col flex-1">
                <span class="text-xs text-gray-500 mb-1">{{ $item->kategori }}</span>

                <h2 class="font-semibold mb-1">{{ $item->nama_barang }}</h2>

                <p class="text-sm text-gray-500 line-clamp-2 mb-2">
                    {{ $item->deskripsi }}
                </p>

                <p class="font-bold text-emerald-600 mb-1">
                    Rp {{ number_format($item->harga,0,',','.') }}/hari
                </p>

                <p id="stok-{{ $item->idbarang }}" class="text-xs text-gray-500">
                    Stok: {{ $item->stok }}
                </p>

                <span id="status-{{ $item->idbarang }}"
                      class="inline-block mt-2 text-xs px-2 py-1 rounded
                      {{ $item->stok > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $item->stok > 0 ? 'Tersedia' : 'Habis' }}
                </span>

                <div class="mt-auto pt-4 grid grid-cols-2 gap-2">
                    <button
                        class="btn-detail bg-gray-100 hover:bg-gray-200 text-sm rounded-lg py-2"
                        data-nama="{{ $item->nama_barang }}"
                        data-kategori="{{ $item->kategori }}"
                        data-deskripsi="{{ $item->deskripsi }}"
                        data-harga="{{ $item->harga }}"
                        data-stok="{{ $item->stok }}"
                        data-status="{{ $item->stok > 0 ? 'Tersedia' : 'Habis' }}"
                        data-gambar="{{ $item->gambar ? asset('storage/'.$item->gambar) : '' }}">
                        Detail
                    </button>

                    @if ($item->stok > 0)
                        @auth
                        <form action="{{ route('keranjang.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $item->idbarang }}">
                            <input type="hidden" name="qty" value="1">
                            <button class="btn-glow bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded-lg py-2 w-full">
                                + Keranjang
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}"
                           class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded-lg py-2 text-center">
                            Login
                        </a>
                        @endauth
                    @else
                        <button class="bg-gray-300 text-gray-500 text-sm rounded-lg py-2 cursor-not-allowed" disabled>
                            Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-500">
                Tidak ada produk
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-10">
        {{ $items->links() }}
    </div>
</main>

{{-- MODAL --}}
<div id="detailModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl w-96 p-6 relative modal-animate">
        <button onclick="closeDetailModal()" class="absolute top-3 right-3 text-gray-400">✕</button>

        <h2 id="modalNama" class="font-bold text-lg mb-1"></h2>
        <p id="modalKategori" class="text-sm text-gray-500 mb-2"></p>
        <p id="modalDeskripsi" class="text-sm text-gray-600 mb-3"></p>

        <p class="font-bold text-emerald-600 mb-1">
            Rp <span id="modalHarga"></span>/hari
        </p>

        <p class="text-sm text-gray-500 mb-1">
            Stok: <span id="modalStok"></span>
        </p>

        <span id="modalStatus" class="text-xs px-2 py-1 rounded"></span>

        <div class="h-40 bg-gray-100 mt-4 rounded flex items-center justify-center">
            <img id="modalImage" class="max-h-full hidden">
            <span id="noImage" class="text-gray-400">No Image</span>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.btn-detail').forEach(btn => {
    btn.onclick = () => {
        modalNama.innerText = btn.dataset.nama;
        modalKategori.innerText = btn.dataset.kategori;
        modalDeskripsi.innerText = btn.dataset.deskripsi || '-';
        modalHarga.innerText = btn.dataset.harga;
        modalStok.innerText = btn.dataset.stok;

        modalStatus.innerText = btn.dataset.status;
        modalStatus.className = btn.dataset.status === 'Tersedia'
            ? 'text-xs px-2 py-1 bg-green-100 text-green-700 rounded'
            : 'text-xs px-2 py-1 bg-red-100 text-red-700 rounded';

        if (btn.dataset.gambar) {
            modalImage.src = btn.dataset.gambar;
            modalImage.classList.remove('hidden');
            noImage.classList.add('hidden');
        } else {
            modalImage.classList.add('hidden');
            noImage.classList.remove('hidden');
        }

        detailModal.classList.remove('hidden');
        detailModal.classList.add('flex');
    }
});

function closeDetailModal() {
    detailModal.classList.add('hidden');
    detailModal.classList.remove('flex');
}
</script>

<footer class="bg-gray-900 py-6 text-center text-sm text-gray-400">
    &copy; {{ date('Y') }} Goutside. All rights reserved.
</footer>

</body>
</html>
