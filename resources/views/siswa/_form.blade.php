<div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="text" id="nis" name="nis" placeholder="Masukkan nis" required value="{{ old('nis', $siswa->nis ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="nama_siswa">Nama Siswa</label>
                    <input type="text" id="nama_siswa" name="nama_siswa" placeholder="Masukkan nama_siswa"  value="{{ old('nama_siswa', $siswa->nama_siswa ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <input type="text" id="kelas" name="kelas" placeholder="Masukkan kelas" required value="{{ old('kelas', $siswa->kelas ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <input type="text" id="jurusan" name="jurusan" placeholder="Masukkan jurusan" required value="{{ old('jurusan', $siswa->jurusan ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="no_hp">No HP</label>
                    <input type="text" id="no_hp" name="no_hp" placeholder="Masukkan no hp" required value="{{ old('no_hp', $siswa->no_hp ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Masukkan email" required value="{{ old('email', $siswa->email ?? '') }}">
                </div>

                <button type="submit" class="btn-submit">Simpan</button>
                <a href="{{ route('siswa.index') }}" class="btn-back">Kembali</a>