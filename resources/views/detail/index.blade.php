@extends('layouts.app')
@section('title', 'Detail Peminjaman')
@section('content')
<div class="data">
    <h2>Daftar Detail Peminjaman Buku</h2>

    <div class="table">
        <table>
            <thead>
                <tr>
                    <td>No</td>
                    <td>ID Peminjaman</td>
                    <td>ID Buku</td>
                    <td>Jumlah</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                 @foreach ($detail as $details)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$details->peminjaman_id}}</td>
                            <td>{{ $details->book->judul_buku ?? $details->book_id }}</td>
                            <td>{{$details->jumlah}}</td>
                            <td class='table-action'>
                                @if(($details->status ?? 'dipinjam') === 'dikembalikan')
                                    <span class="badge">Sudah Dikembalikan</span>
                                @else
                                    <form action="{{ route('detail.kembalikan', $details->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        <button type="submit" class="btn-dikembalikan" onclick="return confirm('Kembalikan buku ini?')">Kembalikan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</div>