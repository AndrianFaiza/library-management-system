@extends('layouts.app')
@section('title', 'Daftar Rak Buku')
@section('content')
<div class="data">
    <div class="header">
        <h2>Daftar Rak Buku</h2>
        <a href="{{ route('rak.create') }}" class="btn-tambah">+ Tambah Rak Buku</a>
    </div>
    <div class="search-group">
        <form method="GET" action="{{route('rak.index')}}">
            <input type="text" name="search" class="search"  placeholder="Cari" value="{{ request('search') }}">
            <button type="submit" class="btn-search">🔍 Cari</button>
        </form>
    </div>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Rak</td>
                    <td>Lokasi</td>
                    <td>Kapasitas</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                 @foreach ($rak as $raks)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$raks->nama_rak}}</td>
                            <td>{{$raks->lokasi}}</td>
                            <td>{{$raks->kapasitas}}</td>
                            <td class="table-action">
                                <a class="btn-edit" href="{{ route('rak.edit', $raks->id) }}">Edit</a>
                                <form action="{{ route('rak.destroy', $raks->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>