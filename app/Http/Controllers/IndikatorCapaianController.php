<?php

namespace App\Http\Controllers;

use App\Models\IndikatorCapaian;
use App\Http\Requests\IndikatorCapaianStoreRequest;
use App\Models\Indikator;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndikatorCapaianController extends Controller
{
    
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

    public function index(Request $request, $slug = null)
    {
        $user = auth()->user();
        $catInfo = $this->getCategoryDetails($slug);
        $namaKategori = $catInfo['name'];
        $kategori = $catInfo['slug'] ?? null;

        $kelas = null;
        $guruId = null;

        if ($user->hasRole('guru')) {
            $guruId = $user->guru?->id;
            $kelas = Kelas::where('wali_kelas_id', $guruId)
                ->orWhere('pendamping_id', $guruId)
                ->first();
        } else {
            $kelas = Kelas::orderBy('rombel', 'asc')->first();
        }

        if (!$kelas) {
            return view('indikatorCapaians.index', [
                'kelas'             => null,
                'guruId'            => $guruId,
                'rencanaIndikator'  => collect(),
                'namaKategori'      => $namaKategori,
                'kategori'          => $kategori,
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
                'kelas_id'     => $kelas->id,
                'indikator_id' => $master->id,
            ]);
        }

        $rencanaIndikator = IndikatorCapaian::where('kelas_id', $kelas->id)
            ->whereHas('indikator', function($query) use ($catInfo) {
                $query->whereIn('capaian_perkembangan_id', $catInfo['ids']);
            })
            ->with('indikator')
            ->get();

        return view('indikatorCapaians.index', compact('rencanaIndikator', 'kelas', 'namaKategori', 'guruId', 'kategori'));
    }
    
    public function create()
    {
        
    }
    public function store(IndikatorCapaianStoreRequest $request)
    {
        $data = $request->validated();

        $kelasId        = $data['kelas_id'];
        $indikatorIds   = $data['indikator_ids'] ?? [];

        if (!empty($indikatorIds)) {
            foreach ($indikatorIds as $indikatorId) {
                IndikatorCapaian::firstOrCreate([
                    'kelas_id' => $kelasId,
                    'indikator_id' => $indikatorId,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Indikator berhasil diperbarui');
    }
  
    public function show(IndikatorCapaian $indikatorCapaian)
    {
        
    }

   
    public function edit(IndikatorCapaian $indikatorCapaian)
    {
        
    }

    
    public function update(Request $request, IndikatorCapaian $indikatorCapaian)
    {
        
    }

    
    public function destroy($id)
    {
        $rencana = IndikatorCapaian::findOrFail($id);
        $rencana->delete();

        return redirect()->back()->with('success', 'Indikator berhasil dihapus');
    }
}
