<?php

namespace App\Http\Controllers;

use App\Http\Requests\NilaiKarakterUpdateRequest;
use App\Models\NilaiKarakter;
use Illuminate\Http\Request;
use App\Models\AnggotaKelas;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\TahunAjaran;
use App\Models\Karakter;
use Illuminate\Support\Facades\Auth;

class NilaiKarakterController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tahunAjaranAktif = TahunAjaran::latest()->first();
        $karakters = Karakter::all(); 

        // Mengecek apakah user yang login adalah guru atau admin
        if ($user->hasRole('guru')) {
            // Logika disamakan persis seperti KehadiranController
            $wali_kelas = Guru::where('user_id', $user->id)->first();
            
            $id_kelas_diampu = Kelas::where('tahun_ajaran_id', $tahunAjaranAktif?->id)
                ->where('wali_kelas_id', $wali_kelas?->id)
                ->pluck('id');

            $data_anggota_kelas = AnggotaKelas::whereIn('kelas_id', $id_kelas_diampu)
                ->with(['siswa', 'kelas'])
                ->get();
        } else {
            // Jika Admin, tampilkan semua data anggota kelas
            $data_anggota_kelas = AnggotaKelas::with(['siswa', 'kelas'])->get();
        }

        return view('nilai_karakters.index', compact('data_anggota_kelas', 'karakters'));
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