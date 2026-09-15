<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\CapaianPerkembangan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Requests\IndikatorUpdateRequest;

class IndikatorController extends Controller
{
    public function index()
    {
        $capaians = CapaianPerkembangan::all();
        $indikators = Indikator::all();
        $tahunAjarans = TahunAjaran::all();

        return view('indikators.index', compact('capaians','indikators','tahunAjarans'));
    }

    public function create()
    {
        return view('indikators.index');
    }

    public function store(IndikatorUpdateRequest $request)
    {
        $data = $request->validated();

        if (Indikator::where('kode', $data['kode'])->exists()) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Kode indikator "' . $data['kode'] . '" sudah tersedia.');
        }

        Indikator::create($data);

        return redirect()
            ->route('karakter.index')
            ->with('success', 'Indikator berhasil disimpan.');
    }

    public function show(string $id)
    {
        return view('indikators.index');
    }

    public function edit(string $id)
    {
        return view('indikators.index', compact('Indikator'));
    }

    public function update(IndikatorUpdateRequest $request, Indikator $indikator)
    {
        $data = $request->validated();

        if ($data['kode'] !== $indikator->id && Indikator::where('kode', $data['kode'])->exists()) {
            return redirect()->back()->withInput()->with('error', 'Gagal! Kode indikator "' . $data['kode'] . '" sudah tersedia.');
        }

        $indikator->update($data);

        return redirect()
            ->route('indikator.index')
            ->with('success', 'Indikator berhasil diperbarui.');
    }

    public function destroy(Indikator $indikator)
    {
        $indikator->delete();
        return redirect()->route('indikator.index')
        ->with('success', 'Indikator Berhasil Dihapus!');
    }
}
