<?php

namespace App\Http\Controllers;

use App\Models\HasilCapaian;
use App\Models\Kelas;
use App\Models\AnggotaKelas;
use App\Models\IndikatorCapaian;
use App\Models\Indikator;
use App\Models\User;
use App\Http\Requests\HasilCapaianUpdateRequest;
use App\Models\CapaianPerkembangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HasilCapaianController extends Controller
{
    
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
    $user = auth()->user();
    
    $catInfo = $this->getCategoryDetails($slug);
    $namaKategori = $catInfo['name'];
    $kategori = $catInfo['slug'];

    $kelas = null;
    $anggotaKelas = collect();
    $rencanaIndikator = collect();

    if ($user->hasRole('guru')) {
        $guruId = $user->guru?->id;
        $kelasList = Kelas::where('wali_kelas_id', $guruId)
            ->orWhere('pendamping_id', $guruId)
            ->get();

        $kelasIds = $kelasList->pluck('id');

        $kelas = $kelasList->first();

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
    } else {
        $kelas = Kelas::orderBy('rombel', 'asc')->first(); 

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

            $anggotaKelas = AnggotaKelas::with(['siswa', 'kelas', 'hasilCapaian'])->get();
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

    
    public function create()
    {
        
    }

   
    public function store(HasilCapaianUpdateRequest $request)
    {
        $data = $request->validated();

        $guruId = $data['guru_id'] ?? null;
        $kategori = $data['kategori'] ?? null;
        $nilaiData = $data['nilai'] ?? null;

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

    
    public function show(HasilCapaian $hasilCapaian)
    {
        
    }

   
    public function edit(HasilCapaian $hasilCapaian)
    {
        
    }

   
    public function update(HasilCapaianUpdateRequest $request, $id = null)
    {
        $data = $request->validated();

        $guruId = $data['guru_id'] ?? null;
        $kategori = $data['kategori'] ?? null;
        $nilaiData = $data['nilai'] ?? null;

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

    
    public function destroy(HasilCapaian $hasilCapaian)
    {

    }
}
