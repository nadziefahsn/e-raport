<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaStoreRequest;
use App\Http\Requests\SiswaUpdateRequest;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswas = Siswa::all();
        $kelas = Kelas::all();

        return view('siswas.index', compact('siswas','kelas',));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('siswas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SiswaStoreRequest $request)
    {
        Siswa::create($request->validated());

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        return redirect()->route('siswa.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SiswaUpdateRequest $request, Siswa $siswa)
    {
        $data = $request->validated();

        $siswa->update($data);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}