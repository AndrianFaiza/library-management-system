<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->search;

    $siswa = Siswa::query()
        ->when($search, function ($query, $search) {
            $query->where('nis', 'like', "%{$search}%")
                  ->orWhere('nama_siswa', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%")
                  ->orWhere('jurusan', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        })->get();

    return view('siswa.index', compact('siswa', 'search'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
       $validated  = $request->validate([
        'nis' => 'required|string|max:255',
        'nama_siswa' => 'required|string|max:255',
        'kelas' => 'required|string|max:255',
        'jurusan' => 'required|string|max:255',
        'no_hp' => 'required|string|max:255',
        'email' => 'required|string|max:255',
       ]);
       
       Siswa::create($validated);
         return redirect()->route('siswa.index');
    }

    public function edit(Siswa $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    /**
     * Update the specified siswa in database.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
        'nis' => 'required|string|max:255',
        'nama_siswa' => 'required|string|max:255',
        'kelas' => 'required|string|max:255',
        'jurusan' => 'required|string|max:255',
        'no_hp' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        ]);

        $siswa->update($validated);
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diperbarui');
    }

    /**
     * Remove the specified siswa from database.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus');
    }
}
