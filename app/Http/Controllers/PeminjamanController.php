<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Book;
use App\Models\Detail;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->search;
    $siswa = Siswa::all();
    $users = User::all();
    $peminjaman = Peminjaman::with('siswa', 'users')
        ->when($search, function ($query, $search) {
            $query->where('nis', 'like', "%{$search}%")
                  ->orWhere('user_id', 'like', "%{$search}%")
                  ->orWhere('tanggal_pinjam', 'like', "%{$search}%")
                  ->orWhere('tanggal_kembali', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  ->orWhere('book_id', 'like', "%{$search}%");
        })->get();

    return view('peminjaman.index', compact('peminjaman', 'siswa', 'users', 'search'));
    }



    public function create()
    {
        $siswa = Siswa::all();
        $users = User::all();
        return view('peminjaman.create', compact('siswa', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|exists:siswa,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'details' => 'required|array|min:1',
            'details.*.book_id' => 'required|exists:book,id',
            'details.*.jumlah' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $header = Peminjaman::create([
                'nis' => $request->nis,
                'user_id' => $request->user_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'dipinjam',
            ]);

            foreach ($request->details as $d) {
                $detail = Detail::create([
                    'peminjaman_id' => $header->id,
                    'book_id' => $d['book_id'],
                    'jumlah' => $d['jumlah'],
                    'status' => $d['status'] ?? 'dipinjam',
                ]);

                if (($d['status'] ?? 'dipinjam') === 'dipinjam') {
                    $book = Book::find($d['book_id']);
                    if ($book) {
                        $book->decrement('jumlah', $d['jumlah']);
                    }
                }
            }
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $siswa = Siswa::all();
        $users = User::all();
        return view('peminjaman.edit', compact('peminjaman', 'siswa', 'users'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $validated = $request->validate([
            'nis' => 'required|exists:siswa,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date',
            'details' => 'required|array',
            'details.*.book_id' => 'required|exists:book,id',
            'details.*.jumlah' => 'required|integer|min:1',
            'details.*.status' => 'nullable|in:dipinjam,dikembalikan',
        ]);

        DB::transaction(function () use ($request, $peminjaman) {
            $peminjaman->update([
                'nis' => $request->nis,
                'user_id' => $request->user_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
            ]);

            $existing = $peminjaman->detail()->get()->keyBy('id');

            $incoming = collect($request->details);

            foreach ($incoming as $inc) {
                if (isset($inc['id']) && $existing->has($inc['id'])) {
                    $old = $existing->get($inc['id']);
                    $oldJumlah = $old->jumlah;
                    $oldStatus = $old->status ?? 'dipinjam';
                    $newStatus = $inc['status'] ?? 'dipinjam';
                    $newJumlah = $inc['jumlah'];

                    if ($oldStatus === 'dipinjam' && $newStatus === 'dipinjam') {
                        $diff = $newJumlah - $oldJumlah;
                        if ($diff > 0) {
                            $book = Book::find($inc['book_id']);
                            if ($book) $book->decrement('jumlah', $diff);
                        } elseif ($diff < 0) {
                            $book = Book::find($inc['book_id']);
                            if ($book) $book->increment('jumlah', abs($diff));
                        }
                    } elseif ($oldStatus === 'dipinjam' && $newStatus === 'dikembalikan') {
                        $book = Book::find($inc['book_id']);
                        if ($book) $book->increment('jumlah', $oldJumlah);
                    } elseif ($oldStatus === 'dikembalikan' && $newStatus === 'dipinjam') {
                        $book = Book::find($inc['book_id']);
                        if ($book) $book->decrement('jumlah', $newJumlah);
                    }

                    $old->update([
                        'book_id' => $inc['book_id'],
                        'jumlah' => $newJumlah,
                        'status' => $newStatus,
                    ]);

                    $existing->forget($inc['id']);
                } else {
                    $detail = Detail::create([
                        'peminjaman_id' => $peminjaman->id,
                        'book_id' => $inc['book_id'],
                        'jumlah' => $inc['jumlah'],
                        'status' => $inc['status'] ?? 'dipinjam',
                    ]);

                    if (($inc['status'] ?? 'dipinjam') === 'dipinjam') {
                        $book = Book::find($inc['book_id']);
                        if ($book) $book->decrement('jumlah', $inc['jumlah']);
                    }
                }
            }

            foreach ($existing as $left) {
                if (($left->status ?? 'dipinjam') === 'dipinjam') {
                    $book = Book::find($left->book_id);
                    if ($book) $book->increment('jumlah', $left->jumlah);
                }
                $left->delete();
            }

            $total = $peminjaman->detail()->count();
            $returned = $peminjaman->detail()->where('status', 'dikembalikan')->count();

            $newStatus = 'dipinjam';
            if ($returned === 0) $newStatus = 'dipinjam';
            elseif ($returned === $total) $newStatus = 'selesai';
            else $newStatus = 'sebagian';

            $peminjaman->update(['status' => $newStatus]);
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        DB::transaction(function () use ($peminjaman) {
            foreach ($peminjaman->detail as $d) {
                if (($d->status ?? 'dipinjam') === 'dipinjam') {
                    $book = Book::find($d->book_id);
                    if ($book) $book->increment('jumlah', $d->jumlah);
                }
                $d->delete();
            }
            $peminjaman->delete();
        });

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus');
    }
}
