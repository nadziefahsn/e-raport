<?php

namespace App\Http\Controllers;

use App\Models\NilaiHafalan;
use App\Models\Hafalan;
use App\Models\TahunAjaran;
use App\Models\Materi;
use App\Models\MateriHafalan;
use App\Models\Kelas;
use App\Models\AnggotaKelas;
use App\Http\Requests\NilaiHafalanUpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NilaiHafalanController extends Controller
{
    private function getCategoryDetails($segment = null)
    {
        if (!$segment) {
            $segment = request()->segment(2) ?? 'materi-hafalan';
        }
        
        $kategoriSlug = str_replace(['materi-', 'hafalan-', 'nilai-'], '', $segment);

        $keywordMapping = [
            'tahsin'          => 'tahsin',
            'doa-harian'      => 'doa harian',
            'tahfidz-alquran' => 'tahfidz',
            'hadits'          => 'hadits',
            'wudhu'           => 'wudhu',
        ];

        $keyword = $keywordMapping[$kategoriSlug] ?? 'hafalan';

        $capaianIds = DB::table('hafalans')
            ->where('capaian_hafalan', 'like', '%' . $keyword . '%')
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
        $tahunAjaranAktif = TahunAjaran::latest()->first();
        if (!$tahunAjaranAktif) {
            return redirect()->route('dashboard');
        }
        
        $user = auth()->user();
        
        $catInfo = $this->getCategoryDetails($slug);
        $namaKategori = $catInfo['name'];
        $kategori = $catInfo['slug'];

        $kelas = null;
        $anggotaKelas = collect();
        $guruId = null;

        if ($user->hasRole('guru')) {
            $guruId = $user->guru?->id;

            $kelas = Kelas::whereTahunAjaranId($tahunAjaranAktif->id)
                ->where(function ($query) use ($guruId) {
                    $query->where('wali_kelas_id', $guruId)
                        ->orWhere('pendamping_id', $guruId);    
                })
                ->first();
        } else {
            $kelas = Kelas::whereTahunAjaranId($tahunAjaranAktif->id)
                ->orderBy('rombel', 'asc')
                ->first();
        }

        if (!$kelas) {
            return view('nilai_hafalans.index', [
                'kelas'         => null,
                'guruId'        => $guruId,
                'masterHafalan' => collect(),
                'anggotaKelas'  => collect(),
                'namaKategori'  => $namaKategori,
                'kategori'      => $kategori,
            ]);
        }

        $anggotaKelas = AnggotaKelas::where('kelas_id', $kelas->id)
            ->with(['siswa', 'nilaiHafalan'])
            ->get();

        $rombelUpper = strtoupper($kelas->rombel);
        if (str_contains($rombelUpper, 'B')) {
            $jenjangTujuan = 'TK B';
        } elseif (str_contains($rombelUpper, 'A')) {
            $jenjangTujuan = 'TK A';
        } else {
            $jenjangTujuan = 'PG';
        }

        $masterMateri = Materi::where('jenjang', $jenjangTujuan)
            ->whereIn('capaian_hafalan_id', $catInfo['ids'])
            ->whereTahunAjaranId($tahunAjaranAktif->id)
            ->get();

        foreach ($masterMateri as $master) {
            MateriHafalan::firstOrCreate([
                'kelas_id'  => $kelas->id,
                'materi_id' => $master->id,
            ]);
        }

        $masterHafalan = MateriHafalan::where('kelas_id', $kelas->id)
            ->whereHas('materi', function($query) use ($catInfo, $tahunAjaranAktif, $jenjangTujuan) {
                $query->whereIn('capaian_hafalan_id', $catInfo['ids'])
                    ->where('jenjang', $jenjangTujuan)
                    ->whereTahunAjaranId($tahunAjaranAktif->id);
            })
            ->with('materi')
            ->get();

        return view('nilai_hafalans.index', [
            'anggotaKelas'  => $anggotaKelas,
            'kelas'         => $kelas,
            'guruId'        => $guruId,
            'masterHafalan' => $masterHafalan,
            'namaKategori'  => $namaKategori,
            'kategori'      => $kategori,
        ]);
    }
    
    public function create()
    {
        //
    }

    public function store(NilaiHafalanUpdateRequest $request)
    {
        $data = $request->validated();

        $guruId = $data['guru_id'] ?? null;
        $kategori = $data['kategori'] ?? null;
        $nilaiData = $data['nilai'] ?? null;

        if ($nilaiData) {
            foreach ($nilaiData as $anggotaKelasId => $materiArray) {
                foreach ($materiArray as $materiId => $nilaiValue) {
                    if (empty($nilaiValue)) {
                        continue;
                    }
                    NilaiHafalan::updateOrCreate(
                        [
                            'anggota_kelas_id' => $anggotaKelasId,
                            'materi_id'        => $materiId,
                        ],
                        [
                            'nilai'            => $nilaiValue,
                        ]
                    );
                }
            }
        }

        return redirect()
            ->route('nilai-hafalan.kategori', ['slug' => $kategori, 'guru_id' => $guruId])
            ->with('success', 'Data nilai hafalan berhasil disimpan.');
    }

    public function show(NilaiHafalan $nilaiHafalan)
    {
        //
    }

    public function edit(NilaiHafalan $nilaiHafalan)
    {
        //
    }

    public function update(NilaiHafalanUpdateRequest $request, $id = null)
    {
        return $this->store($request);
    }

    public function destroy(NilaiHafalan $nilaiHafalan)
    {
        //
    }
}