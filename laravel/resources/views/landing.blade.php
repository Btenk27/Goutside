<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goutside - Sewa Perlengkapan Hiking</title>

    {{-- Load Tailwind & JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900">

    {{-- NAVBAR --}}
    @include('partial.navbar')

    {{-- HERO SECTION --}}
    <section class="bg-gradient-to-r from-emerald-600 to-teal-500 text-white">
        <div class="max-w-6xl mx-auto px-4 py-16 lg:py-24 grid md:grid-cols-2 gap-10 items-center">
            <div>
                <p class="uppercase tracking-wide text-emerald-100 text-sm mb-2">
                    Goutside • Rental Perlengkapan Hiking
                </p>
                <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-4">
                    Sewa gear hiking tanpa ribet, siap naik gunung kapan saja.
                </h1>
                <p class="text-emerald-100 mb-6">
                    Tenda, carrier, jaket gunung, sepatu, dan lainnya. 
                    Booking online, ambil di lokasi, fokus ke perjalananmu.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('katalog.index')}}"
                       class="inline-block bg-white text-emerald-700 font-semibold px-6 py-3 rounded-lg shadow hover:bg-gray-100">
                        Lihat Katalog
                    </a>
                    <a href="{{ route('reservasi.create') ?? '#' }}"
                       class="inline-block border border-white/80 text-white font-semibold px-6 py-3 rounded-lg hover:bg-white/10">
                        Buat Reservasi
                    </a>
                </div>

                <div class="mt-8 flex items-center gap-4 text-sm text-emerald-100">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-xs">A</div>
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-xs">B</div>
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-xs">C</div>
                    </div>
                    <p>Dipercaya puluhan pendaki setiap bulan.</p>
                </div>
            </div>

            <div class="relative">
                <div class="absolute -top-6 -left-6 w-24 h-24 rounded-full bg-emerald-400/40 blur-xl"></div>
                <div class="absolute -bottom-10 -right-4 w-32 h-32 rounded-full bg-teal-400/40 blur-xl"></div>

                <div class="relative bg-white/10 border border-white/20 rounded-2xl p-6 backdrop-blur shadow-2xl">
                    <h2 class="text-lg font-semibold mb-4">Barang populer minggu ini</h2>
                    <div class="space-y-3">
                        @isset($items)
                            @forelse($items as $item)
                                <div class="flex items-center justify-between bg-white/10 rounded-xl px-4 py-3">
                                    <div>
                                        <p class="font-semibold">{{ $item->name }}</p>
                                        <p class="text-xs text-emerald-100">
                                            Rp {{ number_format($item->price_per_day, 0, ',', '.') }}/hari
                                        </p>
                                    </div>
                                    <a href="{{ route('produk.show', $item->id) ?? '#' }}"
                                       class="text-xs bg-white text-emerald-600 px-3 py-1 rounded-full">
                                        Detail
                                    </a>
                                </div>
                            @empty
                                <p class="text-sm text-emerald-100">
                                    Belum ada data barang. Tambahkan dari panel admin.
                                </p>
                            @endforelse
                        @else
                            {{-- Data dummy kalau $items belum dikirim dari controller --}}
                            <div class="flex items-center justify-between bg-white/10 rounded-xl px-4 py-3">
                                <div>
                                    <p class="font-semibold">Tenda Kapasitas 2 Orang</p>
                                    <p class="text-xs text-emerald-100">Rp 50.000/hari</p>
                                </div>
                                <span class="text-xs bg-white text-emerald-600 px-3 py-1 rounded-full">
                                    Contoh
                                </span>
                            </div>
                            <div class="flex items-center justify-between bg-white/10 rounded-xl px-4 py-3">
                                <div>
                                    <p class="font-semibold">Carrier 60L</p>
                                    <p class="text-xs text-emerald-100">Rp 35.000/hari</p>
                                </div>
                                <span class="text-xs bg-white text-emerald-600 px-3 py-1 rounded-full">
                                    Contoh
                                </span>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION KEUNGGULAN --}}
    <section class="py-12 bg-gray-50">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-2xl font-bold text-center mb-8">Kenapa sewa di Goutside?</h2>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white border rounded-xl p-6 shadow-sm">
                    <h3 class="font-semibold mb-2">Peralatan Terawat</h3>
                    <p class="text-sm text-gray-600">
                        Semua perlengkapan dicek dan dibersihkan sebelum dan sesudah pemakaian.
                    </p>
                </div>
                <div class="bg-white border rounded-xl p-6 shadow-sm">
                    <h3 class="font-semibold mb-2">Harga Bersahabat</h3>
                    <p class="text-sm text-gray-600">
                        Paket hemat untuk pendakian rombongan dengan durasi fleksibel.
                    </p>
                </div>
                <div class="bg-white border rounded-xl p-6 shadow-sm">
                    <h3 class="font-semibold mb-2">Booking Online</h3>
                    <p class="text-sm text-gray-600">
                        Cek ketersediaan dan lakukan reservasi kapan saja langsung dari website.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA BAWAH --}}
    <section class="py-12 bg-white border-t">
        <div class="max-w-6xl mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold">Siap untuk pendakian berikutnya?</h2>
                <p class="text-gray-600 text-sm">
                    Pesan perlengkapanmu sekarang sebelum kehabisan slot di tanggal yang kamu mau.
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('katalog.index') ?? '#' }}"
                   class="bg-emerald-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-emerald-700">
                    Lihat Katalog
                </a>
                <a href="{{ route('reservasi.create') ?? '#' }}"
                   class="border border-emerald-600 text-emerald-600 px-5 py-2 rounded-lg text-sm font-semibold hover:bg-emerald-50">
                    Buat Reservasi
                </a>
            </div>
        </div>
    </section>

    <footer class="py-6 bg-gray-900">
        <div class="max-w-6xl mx-auto px-4 text-gray-400 text-sm text-center">
            &copy; {{ date('Y') }} Goutside. All rights reserved.
        </div>
    </footer>

</body>
</html>
