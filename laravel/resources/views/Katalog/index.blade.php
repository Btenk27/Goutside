<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Perlengkapan Hiking - Goutside</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">

    @includeIf('partial.navbar')

    <main class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-4">Katalog Perlengkapan Hiking</h1>
        <p class="text-gray-600 mb-6">Pilih perlengkapan yang kamu butuhkan untuk pendakianmu.</p>

        <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse($items as $item)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
                    <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://via.placeholder.com/400x300' }}"
                         alt="{{ $item->name }}"
                         class="w-full h-32 object-cover">

                    <div class="p-4 flex flex-col flex-1">
                        <h2 class="font-semibold text-base mb-1">{{ $item->name }}</h2>
                        <p class="text-sm text-gray-500 line-clamp-2 mb-2">
                            {{ $item->description }}
                        </p>
                        <p class="text-sm font-bold text-emerald-600">
                            Rp {{ number_format($item->price_per_day, 0, ',', '.') }}/hari
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            Stok: {{ $item->stock }}
                        </p>

                        <div class="mt-auto pt-3">
                            <a href="{{ route('katalog.show', $item->id) }}"
                               class="block text-center text-sm bg-emerald-600 text-white px-3 py-2 rounded-lg hover:bg-emerald-700">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">Belum ada produk yang tersedia.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $items->links() }}
        </div>
    </main>
</body>
</html>
