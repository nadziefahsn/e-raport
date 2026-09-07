<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\User;
use App\Http\Requests\PengumumanStoreRequest;
use App\Http\Requests\PengumumanUpdateRequest;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{

    public function index()
    {
        $pengumumans = Pengumuman::latest()->get();
        
        return view('pengumumans.index', compact('pengumumans'));
    }


    public function create()
    {
        return view('pengumumans.create');
    }


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


    public function show(Pengumuman $pengumuman)
    {

    }

    public function edit(Pengumuman $pengumuman)
    {
        return redirect()
            ->route('pengumuman.index');
    }


    public function update(PengumumanUpdateRequest $request, Pengumuman $pengumuman)
    {
        $data = $request->validated();

        $pengumuman->update($data);

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil diperbarui');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();

        return redirect()
            ->route('pengumuman.index')
            ->with('success', 'Pengumuman berhasil dihapus');
    }
}
