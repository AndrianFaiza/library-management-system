@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="card-group">
    <div class="card1">
        <div class="text">
            <div class="icon"></div>
            <div class="total">
                <span>{{ $totalBooks}}</span>
                <p>Buku</p>
            </div>
        </div>
    </div>
    <div class="card2">
        <div class="text">
            <span>{{ $totalSiswa}}</span>
            <p>Siswa</p>
        </div>
    </div>
    <div class="card3">
        <div class="text">
            <span>{{ $totalPinjam}}</span>
            <p>Peminjaman</p>
        </div>
    </div>
</div>