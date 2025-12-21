<!-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Barang - Goutside</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
     jQuery untuk AJAX
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-900">

    @includeIf('partial.navbar')

    <main class="max-w-xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold mb-4 text-center">Form Reservasi</h1>

        @if ($errors->any())

            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>
                    @endforeach

                </ul>
            </div>
        @endif


        @if (session('success'))

            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif


        <form method="POST" action="{{ route('reservasi.store') }}"
              class="bg-white p-6 rounded-xl shadow space-y-4" id="reservation-form">
            @csrf

            {{-- PILIH KATEGORI --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Kategori</label>
                <select name="kategori" id="kategori"
                        class="w-full border rounded-lg px-3 py-2 text-sm">
                    <option value="">-- Pilih kategori dulu --</option>
                    @foreach ($kategories as $kategori)

                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                    @endforeach

                </select>
            </div>

            {{-- PILIH PRODUK --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Produk</label>
                <select name="produk_id" id="produk_id"
                        class="w-full border rounded-lg px-3 py-2 text-sm"
                        required disabled>
                    <option value="">-- Pilih produk --</option>
                    @if ($selectedProduk)

                        <option value="{{ $selectedProduk->idbarang }}" selected>
                            {{ $selectedProduk->nama_barang }} - Rp {{ number_format($selectedProduk->harga, 0, ',', '.') }}/hari
                        </option>
                    @endif

                </select>
                <div class="text-xs text-gray-500 mt-1" id="product-info"></div>
            </div>

            {{-- INFO PRODUK --}}
            <div id="product-details" class="bg-gray-50 p-4 rounded-lg" style="display: none;">
                <h3 class="font-medium text-gray-700 mb-2">Detail Produk:</h3>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <span class="text-gray-600">Nama:</span>
                        <span id="product-nama" class="font-medium"></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Harga:</span>
                        <span id="product-harga" class="font-medium"></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Stok:</span>
                        <span id="product-stok" class="font-medium"></span>
                    </div>
                    <div>
                        <span class="text-gray-600">Kategori:</span>
                        <span id="product-kategori" class="font-medium"></span>
                    </div>
                </div>
            </div>

            {{-- TANGGAL MULAI --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" id="start_date"
                       value="{{ old('start_date') }}"
                       class="w-full border rounded-lg px-3 py-2 text-sm"
                       required
                       min="{{ date('Y-m-d') }}">
            </div>

            {{-- TANGGAL SELESAI --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" id="end_date"
                       value="{{ old('end_date') }}"
                       class="w-full border rounded-lg px-3 py-2 text-sm" required>
            </div>

            {{-- QTY --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah (qty)</label>
                <input type="number" name="qty" id="qty" min="1"
                       value="{{ old('qty', 1) }}"
                       class="w-full border rounded-lg px-3 py-2 text-sm" required>
                <div class="text-xs text-red-500 mt-1" id="qty-error"></div>
            </div>

            {{-- TOTAL HARGA (OTOMATIS) --}}
            <div class="bg-emerald-50 p-4 rounded-lg">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700">Total Harga:</span>
                    <span id="total-price" class="text-lg font-bold text-emerald-700">Rp 0</span>
                </div>
                <div class="text-xs text-gray-500 mt-1">
                    Durasi: <span id="duration">0</span> hari
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-emerald-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-emerald-700">
                Kirim Reservasi
            </button>
        </form>
    </main>

    <script>$(document).ready(function() {
        const kategoriSelect = $('#kategori');
        const produkSelect = $('#produk_id');
        const productDetails = $('#product-details');
        const startDate = $('#start_date');
        const endDate = $('#end_date');
        const qtyInput = $('#qty');
        const qtyError = $('#qty-error');
        const totalPrice = $('#total-price');
        const durationSpan = $('#duration');

        // Load produk berdasarkan kategori
        kategoriSelect.change(function() {
            const kategori = $(this).val();

            if (kategori) {
                $.ajax({
                    url: '{{ route("get.products.by.category") }}',
                    type: 'GET',
                    data: { kategori: kategori },
                    success: function(data) {
                        produkSelect.empty().prop('disabled', false);
                        produkSelect.append('<option value="">-- Pilih produk --</option>');

                        $.each(data, function(index, product) {
                            produkSelect.append(
                                `<option value="${product.idbarang}" 
                                         data-harga="${product.harga}"
                                         data-stok="${product.stok}"
                                         data-nama="${product.nama_barang}"
                                         data-kategori="${kategori}">
                                    ${product.nama_barang} - Rp ${formatRupiah(product.harga)}/hari
                                </option>`
                            );
                        });

                        productDetails.hide();
                        resetCalculation();
                    },
                    error: function() {
                        alert('Gagal memuat produk. Coba lagi.');
                    }
                });
            } else {
                produkSelect.empty().prop('disabled', true);
                produkSelect.append('<option value="">-- Pilih produk --</option>');
                productDetails.hide();
                resetCalculation();
            }
        });

        // 2. Tampilkan detail produk saat dipilih
        produkSelect.change(function() {
            const selectedOption = $(this).find(':selected');

            if (selectedOption.val()) {
                productDetails.show();
                $('#product-nama').text(selectedOption.data('nama'));
                $('#product-harga').text('Rp ' + formatRupiah(selectedOption.data('harga')) + '/hari');
                $('#product-stok').text(selectedOption.data('stok'));
                $('#product-kategori').text(selectedOption.data('kategori'));

                // Set max qty sesuai stok
                qtyInput.attr('max', selectedOption.data('stok'));
                calculateTotal();
            } else {
                productDetails.hide();
                resetCalculation();
            }
        });

        // 3. Hitung total harga
        function calculateTotal() {
            const selectedProduct = produkSelect.find(':selected');
            const harga = parseFloat(selectedProduct.data('harga') || 0);
            const qty = parseInt(qtyInput.val() || 0);
            const start = new Date(startDate.val());
            const end = new Date(endDate.val());

            if (harga && qty && start && end && start <= end) {
                const days = Math.floor((end - start) / (86400000)) + 1;
                const total = harga * qty * days;

                durationSpan.text(days);
                totalPrice.text('Rp ' + formatRupiah(total));

                // Validasi stok
                const stock = parseInt(selectedProduct.data('stok') || 0);
                if (qty > stock) {
                    qtyError.text('Stok tidak cukup! Maksimal: ' + stock);
                } else {
                    qtyError.text('');
                }
            } else {
                resetCalculation();
            }
        }

        // 4. Reset perhitungan
        function resetCalculation() {
            durationSpan.text('0');
            totalPrice.text('Rp 0');
            qtyError.text('');
        }

        // 5. Format Rupiah
        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // 6. Event listeners untuk kalkulasi realtime
        produkSelect.on('change', calculateTotal);
        startDate.on('change', function() {
            endDate.attr('min', $(this).val());
            if (endDate.val() && endDate.val() < $(this).val()) {
                endDate.val($(this).val());
            }
            calculateTotal();
        });
        endDate.on('change', calculateTotal);
        qtyInput.on('input', calculateTotal);

        // 7. Jika dari katalog (selectedProduk ada), isi otomatis
        @if($selectedProduk)
            $(document).ready(function() {
                // Auto-select kategori
                $('#kategori').val('{{ $selectedProduk->kategori }}').trigger('change');

                // Tunggu sebentar lalu select produk
                setTimeout(function() {
                    $('#produk_id').val('{{ $selectedProduk->idbarang }}').trigger('change');
                }, 500);
            });
        @endif
    });</script>

</body>
</html> -->
