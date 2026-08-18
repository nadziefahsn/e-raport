<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\User;
use App\Http\Requests\PengumumanStoreRequest;
use App\Http\Requests\PengumumanUpdateRequest;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengumumans = Pengumuman::latest()->get();
        
        return view('pengumumans.index', compact('pengumumans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pengumumans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PengumumanStoreRequest $request)
    {
        Pengumuman::create([
            'user_id' => auth()->id(),
            'judul' => $request->judul,
            'isi' => $request->isi,
        ]);

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengumuman $pengumuman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengumuman $pengumuman)
    {
        return redirect()
            ->route('pengumuman.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PengumumanUpdateRequest $request, Pengumuman $pengumuman)
    {
        $data = $request->validated();

        $pengumuman->update($data);

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus');
    }
}
