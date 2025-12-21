<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hiking Rent</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-950 text-slate-100 antialiased">

    @include('partial.navbar')

    <main class="max-w-7xl mx-auto px-4 py-8 space-y-8">
        {{-- Heading --}}
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Admin Dashboard</h1>
        <p class="text-sm text-slate-400 mt-1">
            Ringkasan cepat aktivitas penyewaan perlengkapan hiking.
        </p>
    </div>

    <div class="flex flex-wrap gap-2">
        {{-- Tombol Tambah Produk --}}
        <a href="{{ route('admin.produk.create') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-emerald-600">
            + Tambah Produk
        </a>

        {{-- Tombol Daftar Produk --}}
        <a href="{{ route('admin.produk.index') }}"
            class="inline-flex items-center gap-2 rounded-lg bg-sky-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-sky-600">
            Daftar Produk
        </a>
    </div>
</header>


        {{-- STAT CARDS --}}
        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-emerald-500/40 bg-slate-900/60 p-4">
                <p class="text-xs font-semibold text-emerald-300 uppercase tracking-wide">Total Produk</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ $totalProduk }}</p>
                <p class="mt-1 text-xs text-slate-400">Jumlah perlengkapan yang tersedia di katalog.</p>
            </div>

            <div class="rounded-2xl border border-sky-500/40 bg-slate-900/60 p-4">
                <p class="text-xs font-semibold text-sky-300 uppercase tracking-wide">Total Reservasi</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ $totalReservasi }}</p>
                <p class="mt-1 text-xs text-slate-400">Semua reservasi yang pernah dibuat.</p>
            </div>

            <div class="rounded-2xl border border-amber-500/40 bg-slate-900/60 p-4">
                <p class="text-xs font-semibold text-amber-300 uppercase tracking-wide">Menunggu Konfirmasi</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ $pendingReservasi }}</p>
                <p class="mt-1 text-xs text-slate-400">Reservasi dengan status <span
                        class="font-semibold">pending</span>.</p>
            </div>

            <div class="rounded-2xl border border-emerald-400/40 bg-slate-900/60 p-4">
                <p class="text-xs font-semibold text-emerald-300 uppercase tracking-wide">Disetujui</p>
                <p class="mt-2 text-3xl font-bold text-white">{{ $approvedReservasi }}</p>
                <p class="mt-1 text-xs text-slate-400">Reservasi yang sudah disetujui.</p>
            </div>
        </section>

        {{-- TABEL RESERVASI TERBARU --}}
        <section class="bg-slate-900/70 border border-slate-800 rounded-2xl overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-slate-800">
                <h2 class="text-sm font-semibold text-slate-100">Reservasi Terbaru</h2>
                <span class="text-[11px] px-2 py-1 rounded-full bg-slate-800 text-slate-300">
                    {{ $latestReservations->count() }} reservasi terakhir
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead class="bg-slate-900/80 text-slate-300">
                        <tr>
                            <th class="px-4 py-2 border-b border-slate-800">Kode</th>
                            <th class="px-4 py-2 border-b border-slate-800">Customer</th>
                            <th class="px-4 py-2 border-b border-slate-800">Produk</th>
                            <th class="px-4 py-2 border-b border-slate-800">Periode</th>
                            <th class="px-4 py-2 border-b border-slate-800">Qty</th>
                            <th class="px-4 py-2 border-b border-slate-800">Total</th>
                            <th class="px-4 py-2 border-b border-slate-800">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        @forelse ($latestReservations as $res)
                            <tr class="hover:bg-slate-900/80">
                                <td class="px-4 py-2 font-mono text-xs text-slate-200">
                                    {{ $res->reservation_code }}
                                </td>
                                <td class="px-4 py-2 text-slate-200">
                                    {{ $res->user->name ?? 'Guest' }}
                                <td class="px-4 py-2 text-slate-200">
                                    @foreach ($res->items as $item)
                                        {{ $item->produk_nama }} ({{ $item->qty }})<br>
                                    @endforeach
                                </td>
                                <td class="px-4 py-2 text-slate-300">
                                    {{ $res->start_date }} s/d {{ $res->end_date }}
                                </td>
                                <td class="px-4 py-2 text-slate-200">
                                    {{ $res->items->sum('qty') }}
                                </td>

                                <td class="px-4 py-2 text-emerald-300 font-semibold">
                                    Rp {{ number_format($res->items->sum('subtotal'), 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2">
                                    <form method="POST"
                                        action="{{ route('admin.reservasi.update-status', $res->id) }}">
                                        @csrf
                                        @method('PATCH')

                                        <select name="status" onchange="this.form.submit()"
                                            class="text-xs rounded-lg bg-slate-800 border border-slate-700 text-white px-2 py-1">

                                            <option value="pending" {{ $res->status === 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>

                                            <option value="approved"
                                                {{ $res->status === 'approved' ? 'selected' : '' }}>
                                                Disetujui
                                            </option>

                                            <option value="cancelled"
                                                {{ $res->status === 'cancelled' ? 'selected' : '' }}>
                                                Dibatalkan
                                            </option>

                                            <option value="dikembalikan"
                                                {{ $res->status === 'dikembalikan' ? 'selected' : '' }}>
                                                Dikembalikan
                                            </option>
                                        </select>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-slate-500 text-sm">
                                    Belum ada reservasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>

</html>
