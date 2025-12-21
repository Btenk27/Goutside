<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Admin</title>
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

        .action-btn {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .action-edit {
            background-color: #f59e0b;
            color: #ffffff;
        }

        .action-edit:hover {
            background-color: #d97706;
        }

        .action-delete {
            background-color: #ef4444;
            color: #ffffff;
        }

        .action-delete:hover {
            background-color: #b91c1c;
        }
    </style>
</head>
<body class="antialiased">

@include('partial.navbar')

<main class="max-w-7xl mx-auto px-4 py-8 space-y-6">

    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Daftar Produk</h1>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.produk.create') }}" class="btn-primary text-sm">+ Tambah Produk</a>
            <a href="{{ route('admin.dashboard') }}" class="btn-secondary text-sm">Dashboard</a>
        </div>
    </header>

    <section class="card overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produk as $p)
                    <tr>
                        <td>{{ $p->idbarang }}</td>
                        <td>{{ $p->nama_barang }}</td>
                        <td class="text-emerald-500 font-semibold">Rp {{ number_format($p->harga) }}</td>
                        <td>{{ $p->status }}</td>
                        <td>{{ $p->stok }}</td>
                        <td>{{ $p->kategori }}</td>
                        <td class="flex flex-wrap gap-1">
                            <a href="{{ route('admin.produk.edit', $p->idbarang) }}" 
                               class="action-btn action-edit">Edit</a>
                            <form action="{{ route('admin.produk.destroy', $p->idbarang) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="action-btn action-delete"
                                        onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-400 py-4">Belum ada produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

</main>
</body>
</html>