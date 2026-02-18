<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Detail;
use App\Models\Peminjaman;
use App\Models\Book;
use Illuminate\View\View;

class DetailController extends Controller
{
    public function index()
    {
        $query = Detail::query();
        if(request()->has('peminjaman_id')){
            $query->where('peminjaman_id', request('peminjaman_id'));
        }

        $detail = $query->get();
        $peminjaman = Peminjaman::all();
        $book = Book::all();

        return view('detail.index', compact('detail', 'peminjaman', 'book'));
    }

    public function create()
    {
        $peminjaman = Peminjaman::all();
        $book = Book::all();
        return view('detail.create', compact('peminjaman', 'book'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'book_id' => 'required|exists:book,id',
            'jumlah' => 'required|number',
        ]);

        Detail::create($validated);
        return redirect()->route('detail.index')->with('success', 'Detail berhasil ditambahkan');
    }

    public function edit(Detail $detail)
    {
        $peminjaman = Peminjaman::all();
        $book = Book::all();
        return view('detail.edit', compact('detail', 'peminjaman', 'book'));
    }

    public function update(Request $request, Detail $detail)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'id_buku' => 'required|exists:book,id',
            'jumlah' => 'required|number',
        ]);

        $detail->update($validated);
        return redirect()->route('detail.index')->with('success', 'Detail berhasil diperbarui');
    }

    public function destroy(Detail $detail)
    {
        $detail->delete();
        return redirect()->route('detail.index')->with('success', 'Detail berhasil dihapus');
    }
}
