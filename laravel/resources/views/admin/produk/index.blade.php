<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 antialiased">

@include('partial.navbar')

<main class="max-w-7xl mx-auto px-4 py-8 space-y-6">

    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Daftar Produk</h1>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.produk.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-600">
                + Tambah Produk
            </a>
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-sky-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-sky-600">
                Dashboard
            </a>
        </div>
    </header>

    <section class="bg-slate-900/70 border border-slate-800 rounded-2xl overflow-x-auto shadow">
        <table class="min-w-full text-sm text-left divide-y divide-slate-800">
            <thead class="bg-slate-900/80 text-slate-300">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Harga</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Stok</th>
                    <th class="px-4 py-2">Kategori</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                @forelse ($produk as $p)
                    <tr class="hover:bg-slate-800">
                        <td class="px-4 py-2">{{ $p->idbarang }}</td>
                        <td class="px-4 py-2">{{ $p->nama_barang }}</td>
                        <td class="px-4 py-2 text-emerald-300 font-semibold">Rp {{ number_format($p->harga) }}</td>
                        <td class="px-4 py-2">{{ $p->status }}</td>
                        <td class="px-4 py-2">{{ $p->stok }}</td>
                        <td class="px-4 py-2">{{ $p->kategori }}</td>
                        <td class="px-4 py-2 flex flex-wrap gap-1">
                            <a href="{{ route('admin.produk.edit', $p->idbarang) }}"
                               class="px-2 py-1 text-xs rounded bg-amber-500 hover:bg-amber-600 text-white">Edit</a>
                            <form action="{{ route('admin.produk.destroy', $p->idbarang) }}" method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-2 py-1 text-xs rounded bg-red-600 hover:bg-red-700 text-white"
                                        onclick="return confirm('Yakin hapus produk ini?')">Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-slate-400">
                            Belum ada produk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

</main>
</body>
</html>
