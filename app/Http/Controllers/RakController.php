<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rak;
use Illuminate\View\View;


class RakController extends Controller
{
    public function index(Request $request)
    {
    $search = $request->search;

    $rak = Rak::query()
        ->when($search, function ($query, $search) {
            $query->where('nama_rak', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('kapasitas', 'like', "%{$search}%");
        })->get();

    return view('rak.index', compact('rak', 'search'));
    }

    public function create()
    {
        return view('rak.create');
    }

    public function store(Request $request)
    {
       $validated  = $request->validate([
        'nama_rak' => 'required|string|max:255',
        'lokasi' => 'required|string|max:255',
        'kapasitas' => 'required|string|max:255',
       ]);
       
       Rak::create($validated);
         return redirect()->route('rak.index');
    }

    public function edit(Rak $rak)
    {
        return view('rak.edit', compact('rak'));
    }

    /**
     * Update the specified rak in database.
     */
    public function update(Request $request, Rak $rak)
    {
        $validated = $request->validate([
            'nama_rak' => 'required|string',
            'lokasi' => 'required|string',
            'kapasitas' => 'required|string',
        ]);

        $rak->update($validated);
        return redirect()->route('rak.index')->with('success', 'Rak berhasil diperbarui');
    }

    /**
     * Remove the specified rak from database.
     */
    public function destroy(Rak $rak)
    {
        $rak->delete();
        return redirect()->route('rak.index')->with('success', 'Rak berhasil dihapus');
    }
}
