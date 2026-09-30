<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaStoreRequest;
use App\Http\Requests\SiswaUpdateRequest;
use App\Imports\SiswaImport;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new SiswaImport, $request->file('file'));

        return redirect()
            ->back()
            ->with('success', 'Data siswa berhasil diimport');
    }

    public function index()
    {
        $siswas = Siswa::all();
        $tahunAjaranAktif = TahunAjaran::latest()->first();
        $kelas = $tahunAjaranAktif 
            ? Kelas::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get() 
            : Kelas::all();

        return view('siswas.index', compact('siswas','kelas',));
    }

    public function create()
    {
        return view('siswas.create');
    }

    public function store(SiswaStoreRequest $request)
    {
        Siswa::firstOrCreate($request->validated());

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil disimpan.');
    }

    public function show(Siswa $siswa)
    {
       
    }


    public function edit(Siswa $siswa)
    {
        return redirect()->route('siswa.index');
    }


    public function update(SiswaUpdateRequest $request, Siswa $siswa)
    {
        $data = $request->validated();

        $siswa->update($data);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }


    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}