<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container1">
        <div class="form-container">
            <h2>Tambah Data Siswa</h2>
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf
                
                @include('siswa._form')
            </form>
        </div>
    </div>
</body>
</html>