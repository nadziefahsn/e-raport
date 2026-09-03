<?php

namespace App\Http\Controllers;

use App\Models\HasilCapaian;
use App\Models\Kelas;
use App\Models\AnggotaKelas;
use App\Models\IndikatorCapaian;
use App\Models\Indikator;
use App\Models\CapaianPerkembangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilCapaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private function getCategoryDetails($segment = null)
    { 
        if (!$segment) {
            $segment = request()->segment(3) ?? 'aqidah';
        }

        $kategoriSlug = str_replace('indikator-', '', $segment);

        $keywordMapping = [
            'aqidah'              => 'aqidah',
            'ibadah'              => 'ibadah',
            'akhlaq'              => 'akhlaq',
            'disiplin'            => 'disiplin dan kendali diri',
            'al-quran'            => 'alquran',
            'keagamaan'           => 'wawasan keagamaan',
            'kesehatan-kebugaran' => 'kesehatan dan kebugaran',
            'life-skill'          => 'life skill dan jiwa wirausaha',
        ];

        $keyword = $keywordMapping[$kategoriSlug]?? 'aqidah';

        $capaianIds = DB::table('capaians')
            ->whereRaw('LOWER(capaian_perkembangan) = ?',[strtolower($keyword)])
            ->pluck('id')
            ->toArray();

            return [
                'slug' => $kategoriSlug,
                'ids' => $capaianIds,
                'name' => ucwords(str_replace('-','', $kategoriSlug))
            ];
    }

    public function index(Request $request, $slug = null)
    {
        $guruId = $request->query('guru_id')??auth()->user()->guru_id;

        $catInfo = $this->getCategoryDetails($slug);
        $namaKategori = $catInfo['name'];
        $kategori = $catInfo['slug'];

        $kelas = null;
        $anggotaKelas = collect();
        $rencanaIndikator = collect();

        if ($guruId) {
            $kelas = Kelas::where('wali_kelas_id', $guruId)->first();

            if ($kelas) {
                $rombelUpper = strtoupper($kelas->rombel);
                $jenjangTujuan = str_contains($rombelUpper, 'B') ? 'TK B' : 
                                (str_contains($rombelUpper, 'A') ? 'TK A' : 'PG');

                $masterIndikator = Indikator::where('jenjang', $jenjangTujuan)
                    ->whereIn('capaian_perkembangan_id', $catInfo['ids'])
                    ->get();

                    foreach ($masterIndikator as $master){
                        IndikatorCapaian::firstOrCreate([
                            'kelas_id'      => $kelas->id,
                            'indikator_id'  => $master->id,
                        ]);
                    }

                    $rencanaIndikator = IndikatorCapaian::where('kelas_id', $kelas->id)
                    ->whereHas('indikator', function($q) use ($catInfo) {
                        $q->whereIn('capaian_perkembangan_id', $catInfo['ids']);
                    })
                    ->with('indikator')
                    ->get();

                    $anggotaKelas = AnggotaKelas::where('kelas_id', $kelas->id)
                        ->with(['siswa', 'kelas', 'hasilCapaian'])
                        ->get();
            }
        }

        return view('hasil_capaians.index', [
            'anggotaKelas'      => $anggotaKelas,
            'kelas'             => $kelas,
            'guruId'            => $guruId,
            'rencanaIndikator'  => $rencanaIndikator,
            'namaKategori'      => $namaKategori,
            'kategori'          => $kategori,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $guruId = $request->input('guru_id');
        $kategori = $request->input('kategori');
        $nilaiData = $request->input('nilai');

        if ($nilaiData) {
            foreach ($nilaiData as $anggotaKelasId => $indikatorArray) {
                foreach ($indikatorArray as $indikatorId => $nilaiValue) {
                    if (empty($nilaiValue)) {
                        continue;
                    }
                    HasilCapaian::updateOrCreate(
                        [
                            'anggota_kelas_id' => $anggotaKelasId,
                            'indikator_id'     => $indikatorId,
                        ],
                        [
                            'nilai'            => $nilaiValue,
                        ]
                    );
                }
            }
        }
        return redirect()
            ->route('hasil-capaian.kategori', ['slug' => $kategori, 'guru_id' => $guruId])
            ->with('success', 'Data hasil capaian berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HasilCapaian $hasilCapaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HasilCapaian $hasilCapaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id = null)
    {
        $guruId = $request->input('guru_id');
        $kategori = $request->input('kategori');
        $nilaiData = $request->input('nilai');

        if ($nilaiData) {
            foreach ($nilaiData as $anggotaKelasId => $indikatorArray) {
                foreach ($indikatorArray as $indikatorId => $nilaiValue) {
                    if (empty($nilaiValue)) {
                        continue;
                    }

                    HasilCapaian::updateOrCreate(
                        [
                            'anggota_kelas_id' => $anggotaKelasId,
                            'indikator_id'     => $indikatorId,
                        ],
                        [
                            'nilai'            => $nilaiValue,
                        ]
                    );
                }
            }
        }

        return redirect()
            ->route('hasil-capaian.kategori', ['slug' => $kategori, 'guru_id' => $guruId])
            ->with('success', 'Data hasil capaian berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HasilCapaian $hasilCapaian)
    {
        //
    }
}
