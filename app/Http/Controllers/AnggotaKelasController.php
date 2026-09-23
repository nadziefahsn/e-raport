<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\AnggotaKelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\AnggotaKelasStoreRequest;
use App\Http\Requests\AnggotaKelasUpdateRequest;
use App\Models\TahunAjaran;

class AnggotaKelasController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $anggotaKelasQuery = AnggotaKelas::with(['siswa', 'kelas'])->latest();

        if ($user->hasRole('guru')) {
            $tahunAjaranAktif = TahunAjaran::latest()->first();

            $guruId = $user->guru?->id;

            $kelasIds = Kelas::where('wali_kelas_id', $guruId)
                ->orWhere('pendamping_id', $guruId)->whereTahunAjaranId($tahunAjaranAktif->id)
                ->pluck('id');

            $anggotaKelasQuery->whereIn('kelas_id', $kelasIds);
            $kelas = Kelas::whereIn('id', $kelasIds)->orderBy('rombel', 'asc')->get();
        } else {
            $kelas = Kelas::orderBy('rombel', 'asc')->get();
        }

        $anggotaKelas = $anggotaKelasQuery->get();
        $siswas = Siswa::orderBy('nama_siswa', 'asc')->get();

        return view('anggotaKelas.index', compact('anggotaKelas', 'siswas', 'kelas'));
    }

    public function create()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Akses ditolak. Hanya Admin yang dapat menambah data.');
        }

        return view('anggotaKelas.index');
    }

    public function store(AnggotaKelasStoreRequest $request)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->back()->with('error', 'Akses ditolak. Hanya Admin yang dapat menambah data.');
        }

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
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Akses ditolak. Hanya Admin yang dapat mengubah data.');
        }

        return view('anggotaKelas.index', compact('AnggotaKelas'));
    }

    public function update(AnggotaKelasUpdateRequest $request, $id)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->back()->with('error', 'Akses ditolak. Hanya Admin yang dapat mengubah data.');
        }

        $anggotaKelas = AnggotaKelas::findOrFail($id);
        $anggotaKelas->update($request->validated());

        return redirect()
            ->route('anggota-kelas.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasRole('admin')) {
            return redirect()->back()->with('error', 'Akses ditolak. Hanya Admin yang dapat menghapus data.');
        }

        $anggotaKelas = AnggotaKelas::findOrFail($id);
        $anggotaKelas->delete();

        return redirect()
            ->route('anggota-kelas.index')
            ->with('success', 'Siswa berhasil dihapus dari anggota kelas!');
    }
}