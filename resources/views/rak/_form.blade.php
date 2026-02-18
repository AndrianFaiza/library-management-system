<div class="form-group">
                    <label for="nama_rak">Nama Rak</label>
                    <input type="text" id="nama_rak" name="nama_rak" placeholder="Masukkan nama rak" required value="{{ old('nama_rak', $rak->nama_rak ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="lokasi">Penerbit</label>
                    <input type="text" id="lokasi" name="lokasi" placeholder="Masukkan lokasi"  value="{{ old('lokasi', $rak->lokasi ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="kapasitas">Jumlah Buku</label>
                    <input type="number" id="kapasitas" name="kapasitas" placeholder="Masukkan kapasitas" required value="{{ old('kapasitas', $rak->kapasitas ?? '') }}">
                </div>

                <button type="submit" class="btn-submit">Simpan</button>
                <a href="{{ route('rak.index') }}" class="btn-back">Kembali</a>