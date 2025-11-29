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

    <main class="max-w-lg mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold mb-4 text-center">Form Reservasi</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('reservasi.store') }}" class="space-y-4 bg-white p-6 rounded-xl shadow">
            @csrf

            <input type="hidden" name="item_id" value="{{ $item->id ?? '' }}">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                <input type="text" value="{{ $item->name ?? 'Pilih dari katalog' }}" readonly
                       class="w-full bg-gray-100 border rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" required class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" required class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Barang</label>
                <input type="number" name="qty" min="1" value="1" required class="w-full border rounded-lg px-3 py-2 text-sm">
            </div>

            <button type="submit" class="w-full bg-emerald-600 text-white py-2 rounded-lg hover:bg-emerald-700">
                Kirim Reservasi
            </button>
        </form>
    </main>
</body>
</html>
