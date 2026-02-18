<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Detail;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with('users')->get();

        $peminjaman = Peminjaman::all();
        $user = User::all();

        return view('pengembalian.index', compact('pengembalian', 'peminjaman', 'user'));
    }

    public function create()
    {
        $peminjaman = Peminjaman::all();
        $user = User::all();
        return view('pengembalian.create', compact('peminjaman', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tanggal_dikembalikan' => 'required|date',
            'denda' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        Pengembalian::create($validated);
        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil ditambahkan');
    }

    public function edit(Pengembalian $pengembalian)
    {
        $peminjaman = Peminjaman::all();
        $user = User::all();
        return view('pengembalian.edit', compact('pengembalian', 'peminjaman', 'user'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $validated = $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tanggal_dikembalikan' => 'required|date',
            'denda' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        $pengembalian->update($validated);
        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil diperbarui');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $pengembalian->delete();
        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil dihapus');
    }

    public function kembalikan(Detail $detail)
    {
        if (($detail->status ?? 'dipinjam') === 'dikembalikan') {
            return redirect()->back()->with('info', 'Buku sudah dikembalikan');
        }

        DB::transaction(function () use ($detail) {
            $book = Book::find($detail->book_id);
            if ($book) {
                $book->increment('jumlah', $detail->jumlah);
            }

            $detail->update(['status' => 'dikembalikan']);

            $peminjaman = Peminjaman::find($detail->peminjaman_id);

            // per-day fine (IDR) — change as needed or move to config
            $perDay = config('library.denda_per_hari', 1000);

            $denda = 0;
            if ($peminjaman && $peminjaman->tanggal_kembali) {
                $due = Carbon::parse($peminjaman->tanggal_kembali)->startOfDay();
                $returned = Carbon::now()->startOfDay();
                if ($returned->gt($due)) {
                    $daysLate = $returned->diffInDays($due);
                    $denda = $daysLate * $perDay;
                }
            }

            Pengembalian::create([
                'peminjaman_id' => $detail->peminjaman_id,
                'tanggal_dikembalikan' => now()->toDateString(),
                'denda' => $denda,
                'user_id' => auth()->id() ?? 1,
            ]);

            $peminjaman = Peminjaman::find($detail->peminjaman_id);
            if ($peminjaman) {
                $total = $peminjaman->detail()->count();
                $returned = $peminjaman->detail()->where('status', 'dikembalikan')->count();

                $newStatus = 'dipinjam';
                if ($returned === 0) $newStatus = 'dipinjam';
                elseif ($returned === $total) $newStatus = 'selesai';
                else $newStatus = 'sebagian';

                $peminjaman->update(['status' => $newStatus]);
            }
        });

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan');
    }
}
