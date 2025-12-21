<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Saya - Goutside</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 flex flex-col min-h-screen">

    @includeIf('partial.navbar')

    <main class="max-w-5xl mx-auto px-4 py-8 flex-grow">
        <h1 class="text-2xl font-bold mb-6">Reservasi Saya</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if ($reservations->isEmpty())
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <p class="text-gray-500">Belum ada reservasi.</p>
                <a href="{{ route('katalog.index') }}"
                    class="inline-block mt-4 bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700">
                    Mulai Sewa
                </a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th class="text-left px-4 py-3">Kode Reservasi</th>
                            <th class="text-center px-4 py-3">Tanggal</th>
                            <th class="text-center px-4 py-3">Total</th>
                            <th class="text-center px-4 py-3">Status</th>
                            <th class="text-center px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $r)
                            @php
                                $statusText = $r->status === 'dikembalikan' ? 'Selesai' : ucfirst($r->status);

                                $statusClasses = match ($r->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'approved' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    'dikembalikan' => 'bg-sky-100 text-sky-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp

                            <tr class="border-b">
                                <td class="px-4 py-3 font-semibold">
                                    {{ $r->reservation_code }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    {{ \Carbon\Carbon::parse($r->start_date)->format('d M Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse($r->end_date)->format('d M Y') }}
                                </td>

                                <td class="px-4 py-3 text-center font-semibold">
                                    Rp {{ number_format($r->grand_total, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs {{ $statusClasses }}">
                                        {{ $statusText }}
                                    </span>
                                </td>

                                {{-- ✅ AKSI (SUDAH DIPERBAIKI) --}}
                                <td class="px-4 py-3 text-center">
                                    @if ($r->payment_status === 'unpaid' && $r->status === 'pending')
                                        <a href="{{ route('reservasi.pay', $r->id) }}"
                                            class="inline-block bg-emerald-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-emerald-700">
                                            Bayar
                                        </a>
                                    @elseif ($r->payment_status === 'paid')
                                        <span class="text-green-600 text-xs font-semibold">
                                            Sudah Dibayar
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            -
                                        </span>
                                    @endif
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>


    <footer class="py-6 bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 text-gray-400 text-sm text-center">
            &copy; {{ date('Y') }} Goutside. All rights reserved.
        </div>
    </footer>
    
</body>

</html>
