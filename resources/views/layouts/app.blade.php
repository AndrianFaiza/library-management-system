<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <p>MAIN CATEGORY</p>
            <ul>
                <li><a href="/dashboard">Dashboard</a></li>
            </ul>
            <p>APPEARANCE</p>
            <ul>
                <li><a href="{{ route('book.index')}}">Buku</a></li>
                <li><a href="{{ route('rak.index')}}">Rak</a></li>
                <li><a href="{{ route('siswa.index')}}">Siswa</a></li>
                <li><a href="{{ route('peminjaman.index')}}">Peminjaman Buku</a></li>
                <li><a href="{{ route('pengembalian.index')}}">Pengembalian</a></li>
            </ul>
        </div>
        <div class="content">
            <div class="dashboard">
                <p>Library Management System | Admin</p>
                <form method="POST" action="/logout" style="display: inline;">
                    @csrf
                    <button type="submit" class="out">Logout</button>
                </form>
            </div>
            <div class="data1">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>