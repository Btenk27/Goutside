<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Perlengkapan - Goutside</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-image-container {
            height: 200px;
            background-color: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .product-image {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .kategori-active {
            background-color: #059669 !important;
            color: white !important;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen">

    @includeIf('partial.navbar')

    <main class="max-w-6xl mx-auto px-4 py-8 flex-grow">
        <h1 class="text-3xl font-bold mb-4">Katalog Perlengkapan</h1>

        {{-- FILTER KATEGORI --}}
        <div class="mb-6 bg-white rounded-xl shadow-sm p-4">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('katalog.index') }}"
                    class="px-4 py-2 rounded-full {{ !request('kategori') ? 'kategori-active bg-emerald-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Semua Kategori
                </a>
                @foreach ($semuaKategori as $kategori)
                    <a href="{{ route('katalog.index', ['kategori' => $kategori]) }}"
                        class="px-4 py-2 rounded-full {{ request('kategori') == $kategori ? 'kategori-active bg-emerald-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        {{ $kategori }}
                    </a>
                @endforeach
            </div>
            @if (request('kategori'))
                <div class="mt-3 text-sm text-gray-600">
                    Menampilkan: <span class="font-semibold">{{ request('kategori') }}</span>
                    <a href="{{ route('katalog.index') }}" class="ml-2 text-emerald-600 hover:underline">(Hapus filter)</a>
                </div>
            @endif
        </div>

        {{-- Info jumlah produk --}}
        <div class="mb-4 text-sm text-gray-600">
            <span class="font-medium">{{ $items->total() }}</span> produk ditemukan
            @if (request('kategori'))
                dalam kategori <span class="font-medium">{{ request('kategori') }}</span>
            @endif
        </div>

        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse($items as $item)
                <div
                    class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col h-full hover:shadow-md transition-shadow">
                    <div class="product-image-container">
                        @if ($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_barang }}"
                                class="product-image">
                        @else
                            <span class="text-gray-400">No Image</span>
                        @endif
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        @if ($item->kategori)
                            <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded mb-2">
                                {{ $item->kategori }}
                            </span>
                        @endif

                        <h2 class="font-semibold text-base mb-1">{{ $item->nama_barang }}</h2>

                        @if ($item->deskripsi)
                            <p class="text-sm text-gray-500 line-clamp-2 mb-2">
                                {{ $item->deskripsi }}
                            </p>
                        @endif

                        <p class="text-sm font-bold text-emerald-600">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}/hari
                        </p>

                        {{-- STOK --}}
                        <p class="text-xs text-gray-500 mt-1" id="stok-{{ $item->idbarang }}">
                            Stok: {{ $item->stok }}
                        </p>

                        {{-- STATUS --}}
                        <span id="status-{{ $item->idbarang }}" class="inline-block mt-2 px-2 py-1 text-xs rounded
                            {{ $item->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->stok > 0 ? 'Tersedia' : 'Habis' }}
                        </span>

                        {{-- TOMBOL --}}
                        <div class="mt-auto pt-4 border-t">
                            <div class="flex gap-2">
                                <button
                                    class="flex-1 text-sm bg-gray-100 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-200 btn-detail"
                                    data-nama="{{ $item->nama_barang }}"
                                    data-kategori="{{ $item->kategori }}"
                                    data-deskripsi="{{ $item->deskripsi }}"
                                    data-harga="{{ $item->harga }}"
                                    data-stok="{{ $item->stok }}"
                                    data-status="{{ $item->stok > 0 ? 'Tersedia' : 'Habis' }}"
                                    data-gambar="{{ $item->gambar ? asset('storage/' . $item->gambar) : '' }}">
                                    Detail
                                </button>

                                @if ($item->stok > 0)
                                    @auth
                                        <form action="{{ route('keranjang.store') }}" method="POST" class="w-full">
    @csrf
    <input type="hidden" name="produk_id" value="{{ $item->idbarang }}">
    <input type="hidden" name="qty" value="1">
    <button type="submit"
        id="btn-{{ $item->idbarang }}"
        class="w-full text-sm bg-emerald-600 text-white px-3 py-2 rounded-lg hover:bg-emerald-700">
        + Keranjang
    </button>
</form>

                                    @endauth
                                    @guest
                                        <a href="{{ route('login') }}"
                                            class="block w-full text-center text-sm bg-yellow-500 text-white px-3 py-2 rounded-lg hover:bg-yellow-600">
                                            Login dulu
                                        </a>
                                    @endguest
                                @else
                                    <button
                                        class="w-full bg-gray-300 text-gray-500 px-3 py-2 rounded-lg cursor-not-allowed"
                                        disabled>
                                        Habis
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-sm">
                    <p class="text-gray-500 text-lg mb-2">Tidak ada produk yang ditemukan</p>
                    @if (request('kategori'))
                        <p class="text-gray-400 mb-4">Tidak ada produk dalam kategori "{{ request('kategori') }}"</p>
                        <a href="{{ route('katalog.index') }}"
                            class="inline-block px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">
                            Lihat Semua Produk
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if ($items->hasPages())
            <div class="mt-8">
                {{ $items->links() }}
            </div>
        @endif

        {{-- MODAL DETAIL --}}
        <div id="detailModal"
            class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-xl w-96 p-6 relative">
                <button onclick="closeDetailModal()"
                    class="absolute top-3 right-3 text-gray-400 hover:text-black">✕</button>

                <h2 id="modalNama" class="text-lg font-bold mb-2"></h2>
                <p id="modalKategori" class="text-sm text-gray-500 mb-1"></p>
                <p id="modalDeskripsi" class="text-sm text-gray-600 mb-3"></p>

                <p class="font-bold text-emerald-600 mb-1">
                    Rp <span id="modalHarga"></span>/hari
                </p>

                <p class="text-sm text-gray-500">
                    Stok: <span id="modalStok"></span>
                </p>

                <span id="modalStatus" class="inline-block mt-2 px-2 py-1 text-xs rounded"></span>

                <div class="h-40 bg-gray-100 mt-4 flex items-center justify-center rounded">
                    <img id="modalImage" class="max-h-full hidden">
                    <span id="noImage" class="text-gray-400">No Image</span>
                </div>
            </div>
        </div>
    </main>

    <script>
        // DETAIL MODAL
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function () {
                document.getElementById('modalNama').innerText = this.dataset.nama;
                document.getElementById('modalKategori').innerText = this.dataset.kategori || '';
                document.getElementById('modalDeskripsi').innerText = this.dataset.deskripsi || '-';
                document.getElementById('modalHarga').innerText = this.dataset.harga;
                document.getElementById('modalStok').innerText = this.dataset.stok;

                const statusEl = document.getElementById('modalStatus');
                statusEl.innerText = this.dataset.status;
                statusEl.className = this.dataset.status === 'Tersedia' ?
                    'inline-block mt-2 px-2 py-1 text-xs bg-green-100 text-green-800 rounded' :
                    'inline-block mt-2 px-2 py-1 text-xs bg-red-100 text-red-800 rounded';

                const img = document.getElementById('modalImage');
                const noImg = document.getElementById('noImage');
                if (this.dataset.gambar) {
                    img.src = this.dataset.gambar;
                    img.classList.remove('hidden');
                    noImg.classList.add('hidden');
                } else {
                    img.classList.add('hidden');
                    noImg.classList.remove('hidden');
                }

                document.getElementById('detailModal').classList.remove('hidden');
                document.getElementById('detailModal').classList.add('flex');
            });
        });

        function closeDetailModal() {
            document.getElementById('detailModal').classList.add('hidden');
            document.getElementById('detailModal').classList.remove('flex');
        }

        // POLLING STOK REAL-TIME
        setInterval(async () => {
            const response = await fetch('{{ route("produk.stok") }}');
            const data = await response.json();

            data.forEach(p => {
                const stokEl = document.querySelector(`#stok-${p.idbarang}`);
                const btnEl  = document.querySelector(`#btn-${p.idbarang}`);
                const statusEl = document.querySelector(`#status-${p.idbarang}`);

                if (stokEl) stokEl.innerText = p.stok;
                if (btnEl) btnEl.disabled = p.stok <= 0;
                if(statusEl){
                    statusEl.innerText = p.stok > 0 ? 'Tersedia' : 'Habis';
                    statusEl.className = p.stok > 0 ?
                        'inline-block mt-2 px-2 py-1 text-xs bg-green-100 text-green-800 rounded' :
                        'inline-block mt-2 px-2 py-1 text-xs bg-red-100 text-red-800 rounded';
                }
            });
        }, 5000); 
    </script>

    <footer class="py-6 bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 text-gray-400 text-sm text-center">
            &copy; {{ date('Y') }} Goutside. All rights reserved.
        </div>
    </footer>
</body>


</html>
