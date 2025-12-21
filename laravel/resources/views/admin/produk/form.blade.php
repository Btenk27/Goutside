<div class="mb-3">
    <label>Nama Barang</label>
    <input type="text" name="nama_barang" class="form-control"
        value="{{ old('nama_barang', $produk->nama_barang ?? '') }}">
</div>

<div class="mb-3">
    <label>Harga</label>
    <input type="number" name="harga" class="form-control" step="10000"
        value="{{ old('harga', $produk->harga ?? '') }}">
</div>

<div class="mb-3">
    <label>Gambar</label>
    <input type="file" name="gambar" class="form-control">
</div>

<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $produk->deskripsi ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Spesifikasi</label>
    <textarea name="spesifikasi" class="form-control">{{ old('spesifikasi', $produk->spesifikasi ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-control">
        <option value="Tersedia" {{ old('status', $produk->status ?? '') == 'Tersedia' ? 'selected' : '' }}>Tersedia
        </option>
        <option value="Tidak tersedia" {{ old('status', $produk->status ?? '') == 'Tidak tersedia' ? 'selected' : '' }}>
            Tidak tersedia</option>
    </select>
</div>

<div class="mb-3">
    <label>Stok</label>
    <input type="number" name="stok" class="form-control" value="{{ old('stok', $produk->stok ?? '') }}">
</div>

<div class="mb-3">
    <label>Kategori</label>
    <select name="kategori" class="form-control">
        <option value="Tenda" {{ old('kategori', $produk->kategori ?? '') == 'Tenda' ? 'selected' : '' }}>Tenda
        </option>
        <option value="Carier" {{ old('kategori', $produk->kategori ?? '') == 'Carier' ? 'selected' : '' }}>Carier
        </option>
        <option value="Alat Masak" {{ old('kategori', $produk->kategori ?? '') == 'Alat Masak' ? 'selected' : '' }}>Alat
            Masak</option>
        <option value="Elektronik" {{ old('kategori', $produk->kategori ?? '') == 'Elektronik' ? 'selected' : '' }}>
            Elektronik</option>
        <option value="Peralatan Pribadi"
            {{ old('kategori', $produk->kategori ?? '') == 'Peralatan Pribadi' ? 'selected' : '' }}>Peralatan Pribadi
        </option>
        <option value="Survival" {{ old('kategori', $produk->kategori ?? '') == 'Survival' ? 'selected' : '' }}>
            Survival</option>
    </select>

</div>
