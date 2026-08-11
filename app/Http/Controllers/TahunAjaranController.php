<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Http\Requests\TahunAjaranStoreRequest;
use App\Http\Requests\TahunAjaranUpdateRequest;

class TahunAjaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahun_ajarans = TahunAjaran::all();

        return view('tahun.index', compact('tahun_ajarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('tahun_ajaran.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TahunAjaranStoreRequest $request)
    {
        TahunAjaran::create($request->validated());

        return redirect()
            ->route('tahun_ajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TahunAjaran $tahunAjaran)
    {
        return redirect()->route('tahun_ajaran.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TahunAjaran $tahunAjaran)
    {
        return redirect()->route('tahun_ajaran.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        TahunAjaranUpdateRequest $request,
        TahunAjaran $tahunAjaran
    ) {
        $tahunAjaran->update($request->validated());

        return redirect()
            ->route('tahun_ajaran.index')
            ->with('success', 'Tahun ajaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
        $tahunAjaran->delete();

        return redirect()
            ->route('tahun_ajaran.index')
            ->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}