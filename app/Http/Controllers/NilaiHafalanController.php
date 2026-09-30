<?php

namespace App\Http\Controllers;

use App\Models\NilaiHafalan;
use App\Models\Hafalan;
use App\Models\TahunAjaran;
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
        $user = auth()->user();
        
        $catInfo = $this->getCategoryDetails($slug);
        $namaKategori = $catInfo['name'];
        $kategori = $catInfo['slug'];

        $kelas = null;
        $anggotaKelas = collect();
        $masterHafalan = collect();
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

        if ($kelas) {
            $rombelUpper = strtoupper($kelas->rombel);
            $jenjangTujuan = str_contains($rombelUpper, 'B') ? 'TK B' : 
                            (str_contains($rombelUpper, 'A') ? 'TK A' : 'PG');

            $masterHafalan = Hafalan::where('jenjang', $jenjangTujuan)
                ->whereIn('id', $catInfo['ids'])
                ->get();

            $anggotaKelas = AnggotaKelas::where('kelas_id', $kelas->id)
                ->with(['siswa', 'kelas', 'nilaiHafalan'])
                ->get();
        }

        return view('nilai_hafalans.index', [
            'anggotaKelas'  => $anggotaKelas,
            'kelas'         => $kelas,
            'guruId'        => $guruId,
            'masterHafalan' => $masterHafalan,
            'namaKategori'  => $namaKategori,
            'kategori'      => $kategori,
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

    /**
     * Display the specified resource.
     */
    public function show(NilaiHafalan $nilaiHafalan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NilaiHafalan $nilaiHafalan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NilaiHafalanUpdateRequest $request, $id = null)
    {
        return $this->store($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NilaiHafalan $nilaiHafalan)
    {
        //
    }
}