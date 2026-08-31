<?php

namespace App\Http\Controllers;

use App\Models\IndikatorCapaian;
use App\Models\Indikator;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndikatorCapaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private function getCategoryDetails()
    {
        $segment = request()->segment(2); 
        if (!$segment) {
            $segment = 'indikator-capaian';
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
            'ids' => $capaianIds,
            'name' => ucwords(str_replace('-', ' ', $kategoriSlug))
        ];
    }

    public function index(Request $request)
    {
        $catInfo = $this->getCategoryDetails();
        $guruId = $request->query('guru_id', auth()->user()->guru->id ?? null);
        $kelas = Kelas::where('wali_kelas_id', $guruId)->first();
        
        if (!$kelas) {
            return view('indikatorCapaians.index', [
                'kelas' => null,
                'rencanaIndikator' => collect(),
                'namaKategori' => $catInfo['name']
            ]);
        }

        $rombelUpper = strtoupper($kelas->rombel);
        if (str_contains($rombelUpper, 'B')) {
            $jenjangTujuan = 'TK B';
        } elseif (str_contains($rombelUpper, 'A')) {
            $jenjangTujuan = 'TK A';
        } else {
            $jenjangTujuan = 'PG';
        }

        $masterIndikator = Indikator::where('jenjang', $jenjangTujuan)
            ->whereIn('capaian_perkembangan_id', $catInfo['ids'])
            ->get();

        foreach ($masterIndikator as $master) {
            IndikatorCapaian::firstOrCreate([
                'kelas_id' => $kelas->id,
                'indikator_id' => $master->id,
            ]);
        }

        $rencanaIndikator = IndikatorCapaian::where('kelas_id', $kelas->id)
            ->whereHas('indikator', function($query) use ($catInfo) {
                $query->whereIn('capaian_perkembangan_id', $catInfo['ids']);
            })
            ->with('indikator')
            ->get();

        $namaKategori = $catInfo['name'];

        return view('indikatorCapaians.index', compact('rencanaIndikator', 'kelas', 'namaKategori'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'indikator_ids' => 'nullable|array',
            'indikator_ids.*' => 'exists:indikators,id',
        ]);

        $kelasId = $request->kelas_id;
        $indikatorIds = $request->indikator_ids ?? [];

        if (!empty($indikatorIds)) {
            foreach ($indikatorIds as $indikatorId) {
                IndikatorCapaian::firstOrCreate([
                    'kelas_id' => $kelasId,
                    'indikator_id' => $indikatorId,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Indikator Aqidah berhasil diperbarui');
    }
    /**
     * Store a newly created resource in storage.
     */
    

    /**
     * Display the specified resource.
     */
    public function show(IndikatorCapaian $indikatorCapaian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IndikatorCapaian $indikatorCapaian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IndikatorCapaian $indikatorCapaian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rencana = IndikatorCapaian::findOrFail($id);
        $rencana->delete();

        return redirect()->back()->with('success', 'Indikator berhasil dihapus');
    }
}
