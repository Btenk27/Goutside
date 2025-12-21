<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Produk - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
      body {
        background-color: #ffffff; /* putih sama seperti halaman lain */
        color: #1e293b; /* teks gelap */
      }
      .card {
        background-color: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        border: 1px solid #e2e8f0;
      }
      .form-input,
      .form-select,
      .form-textarea {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        transition: all 0.3s;
        color: #1e293b;
      }
      .form-input:focus,
      .form-select:focus,
      .form-textarea:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
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
      .file-input::-webkit-file-upload-button {
        background: linear-gradient(90deg, #10b981, #22d3ee);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.5rem;
        border: none;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.3s;
      }
      .file-input::-webkit-file-upload-button:hover {
        background: linear-gradient(90deg, #22d3ee, #10b981);
      }
    </style>
  </head>

  <body class="antialiased">
    @include('partial.navbar')

    <main class="max-w-4xl mx-auto px-4 py-8">
      {{-- Header --}}
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
        <div>
          <h1 class="text-3xl font-bold">Tambah Produk</h1>
          <p class="text-gray-500 text-sm">Tambahkan perlengkapan hiking baru ke katalog</p>
        </div>
        <div class="flex gap-2">
          <a href="{{ route('admin.produk.index') }}" class="btn-secondary text-sm">
            Lihat Produk
          </a>
          <a href="{{ route('admin.dashboard') }}" class="btn-primary text-sm">Dashboard</a>
        </div>
      </div>

      {{-- Error --}}
      @if ($errors->any())
        <div class="mb-4 rounded-xl bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
          <p class="font-semibold mb-1">Terjadi kesalahan:</p>
          <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Form --}}
      <div class="card">
        <form
          method="POST"
          action="{{ route('admin.produk.store') }}"
          enctype="multipart/form-data"
          class="space-y-5"
        >
          @csrf

          <div>
            <label class="block text-sm font-medium mb-1">Nama Barang</label>
            <input
              type="text"
              name="nama_barang"
              value="{{ old('nama_barang') }}"
              required
              class="form-input w-full"
            />
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Harga per Hari (Rp)</label>
            <input
              type="number"
              name="harga"
              value="{{ old('harga') }}"
              min="0"
              step="1000"
              required
              class="form-input w-full"
            />
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Gambar Produk</label>
            <input type="file" name="gambar" class="file-input w-full text-sm" />
            <p class="mt-1 text-xs text-gray-400">Format: JPG, JPEG, PNG. Maksimal 2MB.</p>
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3" class="form-textarea w-full">
{{ old('deskripsi') }}</textarea
            >
          </div>

          <div>
            <label class="block text-sm font-medium mb-1">Spesifikasi (opsional)</label>
            <textarea name="spesifikasi" rows="3" class="form-textarea w-full">
{{ old('spesifikasi') }}</textarea
            >
          </div>

          <div class="grid gap-4 md:grid-cols-3">
            <div>
              <label class="block text-sm font-medium mb-1">Status</label>
              <select name="status" class="form-select w-full" required>
                <option value="Tersedia" {{ old('status') == 'Tersedia' ? 'selected' : '' }}>
                  Tersedia
                </option>
                <option
                  value="Tidak tersedia"
                  {{ old('status') == 'Tidak tersedia' ? 'selected' : '' }}
                >
                  Tidak tersedia
                </option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Stok</label>
              <input
                type="number"
                name="stok"
                value="{{ old('stok', 0) }}"
                min="0"
                class="form-input w-full"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Kategori</label>
              <select name="kategori" class="form-select w-full">
                <option value="">-- Pilih Kategori --</option>
                <option value="Tenda" {{ old('kategori') == 'Tenda' ? 'selected' : '' }}>
                  Tenda
                </option>
                <option value="Carrier" {{ old('kategori') == 'Carrier' ? 'selected' : '' }}>
                  Carrier
                </option>
                <option value="Alat Masak" {{ old('kategori') == 'Alat Masak' ? 'selected' : '' }}>
                  Alat Masak
                </option>
                <option value="Elektronik" {{ old('kategori') == 'Elektronik' ? 'selected' : '' }}>
                  Elektronik
                </option>
                <option
                  value="Peralatan Pribadi"
                  {{ old('kategori') == 'Peralatan Pribadi' ? 'selected' : '' }}
                >
                  Peralatan Pribadi
                </option>
                <option value="Survival" {{ old('kategori') == 'Survival' ? 'selected' : '' }}>
                  Survival
                </option>
              </select>
            </div>
          </div>

          <div class="flex justify-end gap-2 pt-2">
            <a href="{{ route('admin.produk.index') }}" class="btn-secondary">Batal</a>
            <button type="submit" class="btn-primary">Simpan Produk</button>
          </div>
        </form>
      </div>
    </main>
  </body>
</html>
