@extends('layouts.app')
@section('title', 'Daftar Buku')
@section('content')
<div class="data">
   <div class="header">
        <h2>Daftar Buku</h2>
        <a href="{{ route('book.create') }}" class="btn-tambah">+ Tambah Buku</a>
    </div>
    <div class="search-group">
        <form method="GET" action="{{route('book.index')}}">
            <input type="text" name="search" class="search"  placeholder="Cari" value="{{ request('search') }}">
            <button type="submit" class="btn-search">🔍 Cari</button>
        </form>
    </div>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>ISBN</td>
                    <td>Judul</td>
                    <td>Penerbit</td>
                    <td>Tahun Terbit</td>
                    <td>Pengarang</td>
                    <td>Nama Rak</td>
                    <td>Jumlah</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                 @foreach ($book as $book)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$book->isbn}}</td>
                            <td>{{$book->judul_buku}}</td>
                            <td>{{$book->penerbit}}</td>
                            <td>{{$book->tahun_terbit}}</td>
                            <td>{{$book->pengarang}}</td>
                            <td>{{$book->rak->nama_rak ?? $book->rak_id}}</td>
                            <td>{{$book->jumlah}}</td>
                            <td class='table-action'>
                                    <a class='btn-edit' href="{{ route('book.edit', $book->id) }}" text-decoration:none;'>Edit</a> 
                                    <form action="{{ route('book.destroy', $book->id) }}" method="POST" style="display:inline">
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