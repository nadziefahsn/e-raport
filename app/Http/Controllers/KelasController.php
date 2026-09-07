<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Requests\KelasUpdateRequest;

class KelasController extends Controller
{
   
    public function index()
    {
        $kelas = Kelas::with(['waliKelas','pendamping','tahunAjaran'])->get();
        $gurus = Guru::all();
        $tahunAjarans = TahunAjaran::all();

        return view('kelas.index', compact('kelas','gurus','tahunAjarans'));
    }

   
    public function create()
    {
        return view('kelas.index');
    }

    public function store(KelasUpdateRequest $request)
    {
        Kelas::create($request->validated());

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    
    public function show(string $id)
    {
        return view('kelas.index');
    }

    public function edit(string $id)
    {
        
        return view('kelas.index', compact('Kelas'));
    }

    public function update(KelasUpdateRequest $request, Kelas $kelas)
    {
        $kelas->update($request->validated());

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete($kelas);
        return redirect()->route('kelas.index')
        ->with('success', 'Kelas Berhasil Dihapus!');
    }
}
