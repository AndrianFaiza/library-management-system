@extends('layouts.app')
@section('title', 'Daftar Siswa')

@section('content')
<div class="data">
    <div class="header">
        <h2>Daftar Siswa</h2>
        <a href="{{ route('siswa.create') }}" class="btn-tambah">+ Tambah Siswa</a>
    </div>
    <div class="search-group">
        <form method="GET" action="{{route('siswa.index')}}">
            <input type="text" name="search" class="search"  placeholder="Cari" value="{{ request('search') }}">
            <button type="submit" class="btn-search">🔍 Cari</button>
        </form>
    </div>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>NIS</td>
                    <td>Nama Siswa</td>
                    <td>Kelas</td>
                    <td>Jurusan</td>
                    <td>No HP</td>
                    <td>Email</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                 @foreach ($siswa as $siswas)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$siswas->nis}}</td>
                            <td>{{$siswas->nama_siswa}}</td>
                            <td>{{$siswas->kelas}}</td>
                            <td>{{$siswas->jurusan}}</td>
                            <td>{{$siswas->no_hp}}</td>
                            <td>{{$siswas->email}}</td>
                            <td class='table-action'>
                                    <a class='btn-edit' href="{{ route('siswa.edit', $siswas->id) }}" text-decoration:none;'>Edit</a> 
                                    <form action="{{ route('siswa.destroy', $siswas->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</button>
                                </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>