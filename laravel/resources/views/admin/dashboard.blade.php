<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Goutside</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #ffffff;
            color: #1e293b;
        }

        .card {
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
        }

        .btn-primary {
            background: linear-gradient(90deg, #10b981, #22d3ee);
            color: white;
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #22d3ee, #10b981);
        }

        .btn-secondary {
            border-radius: 0.75rem;
            border: 1px solid #cbd5e1;
            padding: 0.5rem 1rem;
            color: #1e293b;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background-color: #f1f5f9;
        }

        .stat-card {
            background-color: #f8fafc;
            border-radius: 0.75rem;
            padding: 1rem;
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        }

        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        thead th {
            background-color: #f1f5f9;
            color: #1e293b;
            padding: 0.5rem;
            text-align: left;
        }

        tbody td {
            padding: 0.5rem;
            border-top: 1px solid #e2e8f0;
        }

        tbody tr:hover {
            background-color: #f1f5f9;
        }

        select {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            color: #1e293b;
            border-radius: 0.5rem;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>

<body class="antialiased">

@include('partial.navbar')

<main class="max-w-7xl mx-auto px-4 py-8 space-y-8">
    {{-- Heading --}}
    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Admin Dashboard</h1>
            <p class="text-sm mt-1">
                Ringkasan cepat aktivitas penyewaan perlengkapan hiking.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.produk.create') }}" class="btn-primary text-sm">+ Tambah Produk</a>
            <a href="{{ route('admin.produk.index') }}" class="btn-secondary text-sm">Daftar Produk</a>
        </div>
    </header>

    {{-- STAT CARDS --}}
    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="stat-card">
            <p class="text-xs font-semibold uppercase tracking-wide">Total Produk</p>
            <p class="mt-2 text-3xl font-bold">{{ $totalProduk }}</p>
            <p class="mt-1 text-xs text-gray-500">Jumlah perlengkapan yang tersedia di katalog.</p>
        </div>

        <div class="stat-card">
            <p class="text-xs font-semibold uppercase tracking-wide">Total Reservasi</p>
            <p class="mt-2 text-3xl font-bold">{{ $totalReservasi }}</p>
            <p class="mt-1 text-xs text-gray-500">Semua reservasi yang pernah dibuat.</p>
        </div>

        <div class="stat-card">
            <p class="text-xs font-semibold uppercase tracking-wide">Menunggu Konfirmasi</p>
            <p class="mt-2 text-3xl font-bold">{{ $pendingReservasi }}</p>
            <p class="mt-1 text-xs text-gray-500">Reservasi dengan status <span class="font-semibold">pending</span>.</p>
        </div>

        <div class="stat-card">
            <p class="text-xs font-semibold uppercase tracking-wide">Disetujui</p>
            <p class="mt-2 text-3xl font-bold">{{ $approvedReservasi }}</p>
            <p class="mt-1 text-xs text-gray-500">Reservasi yang sudah disetujui.</p>
        </div>
    </section>

    {{-- TABEL RESERVASI TERBARU --}}
    <section class="card">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-sm font-semibold">Reservasi Terbaru</h2>
            <span class="text-xs px-2 py-1 rounded-full bg-gray-200 text-gray-600">
                {{ $latestReservations->count() }} reservasi terakhir
            </span>
        </div>

        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Customer</th>
                        <th>Produk</th>
                        <th>Periode</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestReservations as $res)
                        <tr>
                            <td class="font-mono text-xs">{{ $res->reservation_code }}</td>
                            <td>{{ $res->user->name ?? 'Guest' }}</td>
                            <td>
                                @foreach ($res->items as $item)
                                    {{ $item->produk_nama }} ({{ $item->qty }})<br>
                                @endforeach
                            </td>
                            <td class="text-gray-500">{{ $res->start_date }} s/d {{ $res->end_date }}</td>
                            <td>{{ $res->items->sum('qty') }}</td>
                            <td class="font-semibold text-emerald-500">Rp {{ number_format($res->items->sum('subtotal'), 0, ',', '.') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.reservasi.update-status', $res->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="pending" {{ $res->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $res->status === 'approved' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="cancelled" {{ $res->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                        <option value="dikembalikan" {{ $res->status === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 text-sm py-4">Belum ada reservasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>

</body>

</html>
        