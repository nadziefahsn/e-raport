<?php

namespace App\Http\Controllers;

use App\Models\HasilCapaian;
use App\Models\Kelas;
use App\Models\AnggotaKelas;
use App\Models\IndikatorCapaian;
use App\Models\Indikator;
use App\Models\Guru;
use App\Models\TahunAjaran;
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

        $keyword = $keywordMapping[$kategoriSlug] ?? 'aqidah';

        $capaianIds = DB::table('capaians')
            ->whereRaw('LOWER(capaian_perkembangan) = ?', [strtolower($keyword)])
            ->pluck('id')
            ->toArray();

        return [
            'slug' => $kategoriSlug,
            'ids'  => $capaianIds,
            'name' => ucwords(str_replace('-', ' ', $kategoriSlug))
        ];
    }

    public function index(Request $request, $slug = null)
    {
        $user = auth()->user();
        $tahunAjaranAktif = TahunAjaran::latest()->first();
        
        $catInfo = $this->getCategoryDetails($slug);
        $namaKategori = $catInfo['name'];
        $kategori = $catInfo['slug'];

        $kelas = null;
        $data_anggota_kelas = collect();
        $rencanaIndikator = collect();
        $guruId = null;

        if ($user->hasRole('guru')) {
            $guru = Guru::where('user_id', $user->id)->first();
            $guruId = $guru?->id;

            // Memfilter kelas berdasarkan Tahun Ajaran Aktif dan Wali Kelas
            $kelas = Kelas::where('tahun_ajaran_id', $tahunAjaranAktif?->id)
                ->where(function ($q) use ($guruId) {
                    $q->where('wali_kelas_id', $guruId)
                      ->orWhere('pendamping_id', $guruId);
                })
                ->first();
        } else {
            // Logika untuk Admin
            $kelas = Kelas::where('tahun_ajaran_id', $tahunAjaranAktif?->id)
                ->orderBy('rombel', 'asc')
                ->first() ?? Kelas::orderBy('rombel', 'asc')->first();
        }

        if ($kelas) {
            $rombelUpper = strtoupper($kelas->rombel);
            $jenjangTujuan = str_contains($rombelUpper, 'B') ? 'TK B' : 
                            (str_contains($rombelUpper, 'A') ? 'TK A' : 'PG');

            $masterIndikator = Indikator::where('jenjang', $jenjangTujuan)
                ->whereIn('capaian_perkembangan_id', $catInfo['ids'])
                ->get();

            foreach ($masterIndikator as $master) {
                IndikatorCapaian::firstOrCreate([
                    'kelas_id'     => $kelas->id,
                    'indikator_id' => $master->id,
                ]);
            }

            $rencanaIndikator = IndikatorCapaian::where('kelas_id', $kelas->id)
                ->whereHas('indikator', function($q) use ($catInfo) {
                    $q->whereIn('capaian_perkembangan_id', $catInfo['ids']);
                })
                ->with('indikator')
                ->get();

            // Menggunakan penamaan variabel $data_anggota_kelas
            $data_anggota_kelas = AnggotaKelas::where('kelas_id', $kelas->id)
                ->with(['siswa', 'kelas', 'hasilCapaian'])
                ->get();
        }

        return view('hasil_capaians.index', [
            'data_anggota_kelas' => $data_anggota_kelas,
            'kelas'              => $kelas,
            'guruId'             => $guruId,
            'rencanaIndikator'   => $rencanaIndikator,
            'namaKategori'       => $namaKategori,
            'kategori'           => $kategori,
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