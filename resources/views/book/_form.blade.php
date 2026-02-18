<div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" placeholder="Masukkan isbn" required value="{{ old('isbn', $book->isbn ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="judul_buku">Judul Buku</label>
                    <input type="text" id="judul_buku" name="judul_buku" placeholder="Masukkan judul buku" required value="{{ old('judul_buku', $book->judul_buku ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="penerbit">Penerbit</label>
                    <input type="text" id="penerbit" name="penerbit" placeholder="Masukkan penerbit" required value="{{ old('penerbit', $book->penerbit ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="tahun_terbit">Tahun Terbit</label>
                    <input type="text" id="tahun_terbit" name="tahun_terbit" placeholder="Masukkan tahun terbit" required value="{{ old('tahun_terbit', $book->tahun_terbit ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="pengarang">Pengarang</label>
                    <input type="text" id="pengarang" name="pengarang" placeholder="Masukkan pengarang" required value="{{ old('pengarang', $book->pengarang ?? '') }}">
                </div>

                <div class="form-group">
                    <div>
                        <label for="rak_id">Nama Rak <span>*</span></label>
                        <select name="rak_id">
                                    <option value="">-- Pilih Rak --</option>
                                    @foreach($rak as $raks)
                                        <option value="{{ $raks->id }}"
                                            {{ old('rak_id', $book->rak_id ?? '') == $raks->id ? 'selected' : '' }}>
                                            {{ $raks->nama_rak }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rak_id')
                                    <div>{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah Buku</label>
                    <input type="number" id="jumlah" name="jumlah" placeholder="Masukkan jumlah buku" value="{{ old('jumlah', $book->jumlah ?? '') }}"" required>
                </div>

                <button type="submit" class="btn-submit">Simpan</button>
                <a href="{{ route('book.index') }}" class="btn-back">Kembali</a>