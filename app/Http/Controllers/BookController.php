<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Rak;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;

    $book = Book::with('rak')
        ->when($search, function ($query, $search) {
            $query->where('judul_buku', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
        })
        ->get();

    $rak = Rak::all();

    return view('book.index', compact('book', 'rak', 'search'));
}

    public function create()
    {
        $rak = Rak::all();
        return view('book.create', compact('rak'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|string',
            'judul_buku' => 'required|string',
            'penerbit' => 'required|string',
            'tahun_terbit' => 'required|string',
            'pengarang' => 'required|string',
            'rak_id' => 'required|exists:rak,id',
            'jumlah' => 'required|integer',
        ]);

        Book::create($validated);
        return redirect()->route('book.index')->with('success', 'Book berhasil ditambahkan');
    }

    public function edit(Book $book)
    {
        $rak = Rak::all();
        return view('book.edit', compact('book', 'rak'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'isbn' => 'required|string',
            'judul_buku' => 'required|string',
            'penerbit' => 'required|string',
            'tahun_terbit' => 'required|string',
            'pengarang' => 'required|string',
            'rak_id' => 'required|exists:rak,id',
            'jumlah' => 'required|integer',
        ]);

        $book->update($validated);
        return redirect()->route('book.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('book.index')->with('success', 'Buku berhasil dihapus');
    }
}
