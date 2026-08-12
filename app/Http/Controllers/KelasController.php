<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Requests\KelasStoreRequest;
use App\Http\Requests\KelasUpdateRequest;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::with(['waliKelas','pendamping','tahunAjaran'])->get();
        $gurus = Guru::all();
        $tahunAjarans = TahunAjaran::all();

        return view('kelas.index', compact('kelas','gurus','tahunAjarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kelas.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KelasStoreRequest $request)
    {
        Kelas::create($request->validated());

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('kelas.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        return view('kelas.index', compact('Kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KelasUpdateRequest $request, Kelas $kelas)
    {
        $kelas->update($request->validated());

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        $kelas->delete($kelas);
        return redirect()->route('kelas.index')
        ->with('success', 'Kelas Berhasil Dihapus!');
    }
}
