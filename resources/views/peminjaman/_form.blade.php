<div class="form-group">
    <div>
        <label for="nis">Nama Siswa <span>*</span></label>
        <select name="nis">
            <option value="">-- Pilih Siswa --</option>
            @foreach($siswa as $siswas)
                <option value="{{ $siswas->id }}" {{ old('nis', $peminjaman->nis ?? '') == $siswas->id ? 'selected' : '' }}>
                    {{ $siswas->nama_siswa }}
                </option>
            @endforeach
        </select>
        @error('nis')<div>{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group">
    <div>
        <label for="user_id">Nama User <span>*</span></label>
        <select name="user_id">
            <option value="">-- Pilih User --</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}" {{ old('user_id', $peminjaman->user_id ?? '') == $u->id ? 'selected' : '' }}>
                    {{ $u->name }}
                </option>
            @endforeach
        </select>
        @error('user_id')<div>{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group">
    <label for="tanggal_pinjam">Tanggal Pinjam</label>
    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam', isset($peminjaman) ? $peminjaman->tanggal_pinjam->format('Y-m-d') : '') }}">
</div>

<div class="form-group">
    <label for="tanggal_kembali">Tanggal Kembali</label>
    <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali', isset($peminjaman) ? $peminjaman->tanggal_kembali->format('Y-m-d') : '') }}">
</div>

<div class="form-group">
    <label>Detail Buku</label>
    <table id="details-table" style="width:100%">
        <thead>
            <tr>
                <th>Buku</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $books = App\Models\Book::all(); @endphp
            @if(old('details'))
                @foreach(old('details') as $i => $d)
                    <tr>
                        <td>
                            <select name="details[{{ $i }}][book_id]">
                                <option value="">-- Pilih Buku --</option>
                                @foreach($books as $b)
                                    <option value="{{ $b->id }}" {{ ($d['book_id'] ?? '') == $b->id ? 'selected' : '' }}>{{ $b->judul_buku }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="details[{{ $i }}][jumlah]" value="{{ $d['jumlah'] ?? 1 }}" min="1"></td>
                        <td><button type="button" class="remove-row">Hapus</button></td>
                    </tr>
                @endforeach
            @else
                @if(isset($peminjaman) && $peminjaman->detail->count())
                    @foreach($peminjaman->detail as $i => $det)
                        <tr>
                            <td>
                                <select name="details[{{ $i }}][book_id]">
                                    <option value="">-- Pilih Buku --</option>
                                    @foreach($books as $b)
                                        <option value="{{ $b->id }}" {{ $det->book_id == $b->id ? 'selected' : '' }}>{{ $b->judul_buku }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="details[{{ $i }}][id]" value="{{ $det->id }}">
                                <input type="hidden" name="details[{{ $i }}][status]" value="{{ $det->status ?? 'dipinjam' }}">
                            </td>
                            <td><input type="number" name="details[{{ $i }}][jumlah]" value="{{ $det->jumlah }}" min="1"></td>
                            <td><button type="button" class="remove-row">Hapus</button></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>
                            <select name="details[0][book_id]">
                                <option value="">-- Pilih Buku --</option>
                                @foreach($books as $b)
                                    <option value="{{ $b->id }}">{{ $b->judul_buku }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="details[0][jumlah]" value="1" min="1"></td>
                        <td><button type="button" class="remove-row">Hapus</button></td>
                    </tr>
                @endif
            @endif
        </tbody>
    </table>
    <button type="button" id="add-row">Tambah Baris</button>
</div>

<button type="submit" class="btn-submit">Simpan</button>
<a href="{{ route('peminjaman.index') }}" class="btn-back">Kembali</a>

<script>
document.addEventListener('click', function(e){
    if(e.target && e.target.id === 'add-row'){
        const tbody = document.querySelector('#details-table tbody');
        const index = tbody.querySelectorAll('tr').length;
        const tr = document.createElement('tr');
        const books = `@foreach($books as $b)<option value="{{ $b->id }}">{{ $b->judul_buku }}</option>@endforeach`;
        tr.innerHTML = `<td><select name="details[${index}][book_id]"><option value="">-- Pilih Buku --</option>${books}</select></td><td><input type="number" name="details[${index}][jumlah]" value="1" min="1"></td><td><button type="button" class="remove-row">Hapus</button></td>`;
        tbody.appendChild(tr);
    }

    if(e.target && e.target.classList && e.target.classList.contains('remove-row')){
        const tr = e.target.closest('tr');
        tr.parentNode.removeChild(tr);
    }
});
</script>