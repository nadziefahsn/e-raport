<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatatanUpdateRequest;
use App\Models\Catatan;
use App\Models\Kelas;
use App\Models\AnggotaKelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class CatatanController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $tahunAjaranAktif = TahunAjaran::latest()->first();
        $catatans = collect();
        $kelas = null;

        if ($user->hasRole('guru')) {
            $guruId = $user->guru?->id;

            $kelas = Kelas::whereTahunAjaranId($tahunAjaranAktif->id)
                ->where(function ($query) use ($guruId) {
                    $query->where('wali_kelas_id', $guruId)
                          ->orWhere('pendamping_id', $guruId);    
                })
                ->get();

            $kelasIds = $kelas->pluck('id');

            $catatans = AnggotaKelas::whereIn('kelas_id', $kelasIds)
                ->with(['siswa', 'kelas', 'catatan'])
                ->get();
        } else {
            $kelas = Kelas::orderBy('rombel', 'asc')->get();
            $catatans = AnggotaKelas::with(['siswa', 'kelas', 'catatan'])->get();
        }

        return view('catatans.index', compact('catatans', 'kelas'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Catatan $catatan)
    {
        //
    }

    public function edit(Catatan $catatan)
    {
        //
    }

    public function update(CatatanUpdateRequest $request)
    {
        $validated = $request->validated();
        $guruId = $request->input('guru_id');

        foreach ($validated['catatan'] as $anggotaKelasId => $isiCatatan) {
            Catatan::updateOrCreate(
                ['anggota_kelas_id' => $anggotaKelasId],
                ['catatan' => $isiCatatan]
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Catatan berhasil disimpan');
    }

    public function destroy(Catatan $catatan)
    {
        //
    }
}
