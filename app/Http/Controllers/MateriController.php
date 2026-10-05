<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Hafalan;
use App\Models\TahunAjaran;
use App\Http\Requests\MateriRequest;
use Illuminate\Http\Request;

class MateriController extends Controller
{

    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::latest()->first();
        if (!$tahunAjaranAktif) {
            return redirect()->route('dashboard');
        }

        $hafalans = Hafalan::all();

        $materi = $tahunAjaranAktif 
            ? Materi::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get() 
            : Materi::all();

        return view('materis.index', compact('hafalans', 'materi', 'tahunAjaranAktif'));

    }

    public function create()
    {
        return view('materis.index');
    }

    public function store(MateriRequest $request)
    {
        Materi::create($request->validated());

        return redirect()
            ->route('materi.index')
            ->with('success', ' Data materi berhasil disimpan.');
    }

    public function show(string $id)
    {
        return view('materis.index');
    }

    public function edit(string $id)
    {
        $materi = Materi::findOrFail($id);
        return view('materis.index', compact('materi'));
    }

    public function update(MateriRequest $request, Materi $materi)
    {
        $materi->update($request->validated());

        return redirect()
            ->route('materi.index')
            ->with('success', ' Data materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        $materi->delete();

        return redirect()
            ->route('materi.index')
            ->with('success', 'Data materi Berhasil Dihapus!');
    }
}
