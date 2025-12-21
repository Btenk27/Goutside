<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Saya - Goutside</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* smooth entrance */
        .fade-slide {
            opacity: 0;
            transform: translateY(16px);
            transition: all .6s ease;
        }
        .fade-slide.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* subtle glow */
        .card-glow:hover {
            box-shadow:
                0 20px 40px rgba(16, 185, 129, .12),
                inset 0 0 0 1px rgba(255,255,255,.4);
        }
    </style>
</head>

<body class="bg-gradient-to-b from-slate-50 via-white to-slate-100
text-gray-900 flex flex-col min-h-screen">

@includeIf('partial.navbar')

<main class="max-w-6xl mx-auto px-4 py-12 flex-grow relative">

    {{-- AMBIENT GRADIENT --}}
    <div class="absolute -top-32 -right-32 w-[420px] h-[420px]
    bg-emerald-300/20 rounded-full blur-[140px]"></div>

    {{-- HEADER --}}
    <div class="relative mb-12 fade-slide">
        <h1 class="text-3xl md:text-4xl font-bold tracking-tight">
            Reservasi Saya
        </h1>
        <p class="text-sm text-gray-500 mt-2">
            Riwayat penyewaan perlengkapan outdoor kamu
        </p>
    </div>

    {{-- FLASH --}}
    @if (session('success'))
        <div class="fade-slide mb-6 rounded-2xl
        bg-emerald-100/70 backdrop-blur
        text-emerald-800 px-5 py-4 shadow">
            {{ session('success') }}
        </div>
    @endif

    {{-- EMPTY --}}
    @if ($reservations->isEmpty())
        <div class="fade-slide bg-white/80 backdrop-blur
        p-14 rounded-3xl shadow text-center card-glow">

            <p class="text-gray-500 text-lg mb-6">
                Kamu belum memiliki reservasi
            </p>

            <a href="{{ route('katalog.index') }}"
               class="inline-flex items-center gap-2
               px-7 py-3 rounded-full
               bg-gradient-to-r from-emerald-600 to-cyan-500
               text-white font-semibold
               hover:brightness-110 transition">
                Mulai Sewa
            </a>
        </div>
    @else

    {{-- LIST --}}
    <div class="grid gap-7 relative">
        @foreach ($reservations as $r)
            @php
                $statusText = $r->status === 'dikembalikan'
                    ? 'Selesai'
                    : ucfirst($r->status);

                $statusClasses = match ($r->status) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'approved' => 'bg-emerald-100 text-emerald-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                    'dikembalikan' => 'bg-sky-100 text-sky-800',
                    default => 'bg-gray-100 text-gray-700',
                };
            @endphp

            <div class="fade-slide bg-white/75 backdrop-blur
            rounded-3xl p-6 md:p-7 shadow
            transition card-glow">

                {{-- TOP --}}
                <div class="flex flex-col sm:flex-row sm:items-center
                sm:justify-between gap-4">

                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide">
                            Kode Reservasi
                        </p>
                        <p class="font-semibold text-lg">
                            {{ $r->reservation_code }}
                        </p>
                    </div>

                    <span class="inline-flex px-4 py-1.5
                    rounded-full text-xs font-semibold {{ $statusClasses }}">
                        {{ $statusText }}
                    </span>
                </div>

                {{-- INFO --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5
                mt-6 text-sm">

                    <div>
                        <p class="text-gray-500">Tanggal</p>
                        <p class="font-medium">
                            {{ \Carbon\Carbon::parse($r->start_date)->format('d M Y') }}
                            –
                            {{ \Carbon\Carbon::parse($r->end_date)->format('d M Y') }}
                        </p>
                    </div>

                    <div>
                        <p class="text-gray-500">Total</p>
                        <p class="font-semibold text-emerald-600">
                            Rp {{ number_format($r->grand_total, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex items-end">
                        @if ($r->payment_status === 'unpaid' && $r->status === 'pending')
                            <a href="{{ route('reservasi.pay', $r->id) }}"
                               class="w-full sm:w-auto text-center
                               px-6 py-2 rounded-full
                               bg-gradient-to-r from-emerald-600 to-cyan-500
                               text-white text-sm font-semibold
                               hover:brightness-110 transition">
                                Bayar Sekarang
                            </a>
                        @elseif ($r->payment_status === 'paid')
                            <span class="text-emerald-600 font-semibold text-sm">
                                Sudah Dibayar
                            </span>
                        @else
                            <span class="text-gray-400 text-sm">—</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @endif
</main>

<footer class="py-6 bg-gradient-to-t from-gray-900 to-slate-800 mt-20">
    <div class="max-w-6xl mx-auto px-4 text-gray-400 text-sm text-center">
        &copy; {{ date('Y') }} Goutside. All rights reserved.
    </div>
</footer>

{{-- ANIMATION SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.fade-slide');
    items.forEach((el, i) => {
        setTimeout(() => el.classList.add('show'), i * 120);
    });
});
</script>

</body>
</html>
