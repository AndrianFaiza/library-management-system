@extends('layouts.app')
@section('title', 'Pengembalian Buku')
@section('content')
<div class="data">
    <h2>Daftar Pengembalian Buku</h2>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>ID Peminjaman</td>
                    <td>Tanggal Dikembalikan</td>
                    <td>Denda</td>
                    <td>Petugas</td>
                </tr>
            </thead>
            <tbody>
                 @foreach ($pengembalian as $pengembalians)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$pengembalians->peminjaman_id}}</td>
                            <td>{{ isset($pengembalians->tanggal_dikembalikan) ? $pengembalians->tanggal_dikembalikan->format('Y-m-d') : '' }}</td>
                            <td>Rp{{$pengembalians->denda}}</td>
                            <td>{{ $pengembalians->users->name}}</td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>