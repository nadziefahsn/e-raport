<?php

namespace App\Http\Controllers;

use App\Http\Requests\NilaiKarakterUpdateRequest; // Sesuaikan dengan nama Request kamu
use App\Models\NilaiKarakter;
use Illuminate\Http\Request;
use App\Models\AnggotaKelas;
use App\Models\Kelas;
use App\Models\Karakter;

class NilaiKarakterController extends Controller
{

    public function index(Request $request)
    {
        $guruId = $request->query('guru_id');
        $kelas = null;
        $anggotaKelas = collect();
        $karakters = Karakter::all(); 
        $nilaiExisting = [];

        if ($guruId) {
            $kelas = Kelas::where('wali_kelas_id', $guruId)->first();

            if ($kelas) {
                $anggotaKelas = AnggotaKelas::where('kelas_id', $kelas->id)
                    ->with(['siswa', 'kelas'])
                    ->get();
                
            }
        }

        return view('nilai_karakters.index', compact('anggotaKelas', 'kelas', 'guruId', 'karakters', 'nilaiExisting'));
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $guruId = $request->input('guru_id');
        $nilaiData = $request->input('nilai');

        if ($nilaiData) {
        foreach ($nilaiData as $anggotaKelasId => $karakterArray) {
            foreach ($karakterArray as $karakterId => $nilaiValue) {
                if (empty($nilaiValue)) {
                    continue;
                }
                NilaiKarakter::updateOrCreate(
                    [
                        'anggota_kelas_id' => $anggotaKelasId,
                        'karakter_id'      => $karakterId,
                    ],
                    [
                        'nilai'            => $nilaiValue,
                    ]
                );
            }
        }
    }

    return redirect()
        ->route('nilai-karakter.index', ['guru_id' => $guruId])
        ->with('success', 'Data nilai karakter berhasil disimpan');
    }

    public function show(NilaiKarakter $nilaiKarakter)
    {

    }


    public function edit(NilaiKarakter $nilaiKarakter)
    {
       
    }


    public function update(NilaiKarakterUpdateRequest $request, $id = null)
    {
        $validated = $request->validated();
        $guruId = $request->input('guru_id');

        if (isset($validated['nilai'])) {
            foreach ($validated['nilai'] as $anggotaKelasId => $karakterArray) {
                foreach ($karakterArray as $karakterId => $nilaiValue) {
                    if (empty($nilaiValue)) {
                        continue;
                    }

                    NilaiKarakter::updateOrCreate(
                        [
                            'anggota_kelas_id' => $anggotaKelasId,
                            'karakter_id'      => $karakterId,
                        ],
                        [
                            'nilai'            => $nilaiValue,
                        ]
                    );
                }
            }
        }

        return redirect()
            ->route('nilai_karakters.index', ['guru_id' => $guruId])
            ->with('success', 'Data nilai karakter berhasil disimpan');
    }

    public function destroy(NilaiKarakter $nilaiKarakter)
    {
       
    }
}