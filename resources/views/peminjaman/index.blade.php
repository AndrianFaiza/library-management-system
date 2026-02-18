@extends('layouts.app')
@section('title', 'Peminjaman Buku')
@section('content')
<div class="data">
    <div class="header">
        <h2>Daftar Peminjaman Buku</h2>
        <a href="{{ route('peminjaman.create') }}" class="btn-tambah">+ Tambah Peminjaman</a>
    </div>
    <div class="search-group">
        <form method="GET" action="{{route('peminjaman.index')}}">
            <input type="text" name="search" class="search"  placeholder="Cari" value="{{ request('search') }}">
            <button type="submit" class="btn-search">🔍 Cari</button>
        </form>
    </div>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama</td>
                    <td>Petugas</td>
                    <td>Tanggal Pinjam</td>
                    <td>Tanggal Kembali</td>
                    <td>Status</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                 @foreach ($peminjaman as $peminjamans)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{ $peminjamans->siswa->nama_siswa ?? $peminjamans->nis }}</td>
                            <td>{{ $peminjamans->users->name}}</td>
                            <td>{{ isset($peminjamans->tanggal_pinjam) ? $peminjamans->tanggal_pinjam->format('Y-m-d') : '' }}</td>
                            <td>{{ isset($peminjamans->tanggal_kembali) ? $peminjamans->tanggal_kembali->format('Y-m-d') : '' }}</td>
                            <td>{{$peminjamans->status}}</td>
                            <td class='table-action'>
                                    <a class='btn-edit' href="{{ route('peminjaman.edit', $peminjamans->id) }}">Edit</a>
                                    <form action="{{ route('peminjaman.destroy', $peminjamans->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</button>
                                    </form>
                                    <a class="btn-detail" href="{{ url('detail?peminjaman_id='.$peminjamans->id) }}">Detail</a>
                                    
                                </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>