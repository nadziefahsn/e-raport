<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\AnggotaKelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Http\Requests\AnggotaKelasStoreRequest;
use App\Http\Requests\AnggotaKelasUpdateRequest;


class AnggotaKelasController extends Controller
{
    
    public function index()
    {
        $anggotaKelas = AnggotaKelas::with(['siswa', 'kelas'])->latest()->get();
        $siswas = Siswa::orderBy('nama_siswa', 'asc')->get();
        $kelas = Kelas::orderBy('rombel', 'asc')->get();

        return view('anggotaKelas.index', compact('anggotaKelas', 'siswas', 'kelas'));
    }

   
    public function create()
    {
        return view('anggotaKelas.index');
    }

   
    public function store(AnggotaKelasStoreRequest $request)
    {
        AnggotaKelas::create($request->validated());

        return redirect()
            ->route('anggota-kelas.index')
            ->with('success', 'Data siswa berhasil disimpan.');
    }

   
    public function show(string $id)
    {
        return view('anggotaKelas.index');
    }

   
    public function edit(string $id)
    {
        return view('anggotaKelas.index', compact('AnggotaKelas'));
    }

   
    public function update(AnggotaKelasUpdateRequest $request, $id)
    {
        $anggotaKelas = AnggotaKelas::findOrFail($id);
        $anggotaKelas->update($request->validated());

        return redirect()
            ->route('anggota-kelas.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

   
    public function destroy($id)
    {
        $anggotaKelas = AnggotaKelas::findOrFail($id);
        $anggotaKelas->delete();

        return redirect()
            ->route('anggota-kelas.index')
            ->with('success', 'Siswa berhasil dihapus dari anggota kelas!');
    }
}
