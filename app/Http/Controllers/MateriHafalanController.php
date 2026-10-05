<?php

namespace App\Http\Controllers;

use App\Models\MateriHafalan;
use App\Models\Materi;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class MateriHafalanController extends Controller
{
    private function getCategoryDetails()
    {
        $segment = request()->segment(2); 
        if (!$segment) {
            $segment = 'materi-hafalan';
        }
        
        $kategoriSlug = str_replace(['materi-', 'hafalan-'], '', $segment);

        $keywordMapping = [
            'tahsin'              => 'tahsin',
            'doa-harian'          => 'doa harian',
            'tahfidz-alquran'     => 'tahfidz',
            'hadits'              => 'hadits',
            'wudhu'               => 'wudhu',
        ];

        $keyword = $keywordMapping[$kategoriSlug] ?? 'hafalan';

        $capaianIds = DB::table('hafalans')
            ->where('capaian_hafalan', 'like', '%'. $keyword . '%')
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
        $kategori = $catInfo['slug'] ?? null;

        $kelas = null;
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
            return view('materiHafalans.index', [
                'kelas'         => null,
                'guruId'        => $guruId,
                'materiHafalan' => collect(),
                'namaKategori'  => $namaKategori,
                'kategori'      => $kategori,
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

        $masterMateri = Materi::where('jenjang',$jenjangTujuan)
            ->whereIn('capaian_hafalan_id', $catInfo['ids'])
            ->whereTahunAjaranId($tahunAjaranAktif->id)
            ->get();

        foreach ($masterMateri as$master) {
            MateriHafalan::firstOrCreate([
                'kelas_id'  => $kelas->id,
                'materi_id' => $master->id,
            ]);
        }

        $materiHafalan = MateriHafalan::where('kelas_id',$kelas->id)
            ->whereHas('materi', function($query) use ($catInfo, $tahunAjaranAktif,$jenjangTujuan) {
                $query->whereIn('capaian_hafalan_id',$catInfo['ids'])
                    ->where('jenjang', $jenjangTujuan)
                    ->whereTahunAjaranId($tahunAjaranAktif->id);
            })
            ->with('materi')
            ->get();

        return view('materiHafalans.index', compact('materiHafalan', 'kelas', 'namaKategori', 'guruId', 'kategori', 'tahunAjaranAktif'));
    }
    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id'    => 'required|exists:kelas,id',
            'materi_ids'  => 'nullable|array',
            'materi_ids.*'=> 'exists:materi,id',
        ]);

        $kelasId   = $request->input('kelas_id');
        $materiIds = $request->input('materi_ids', []);

        if (!empty($materiIds)) {
            foreach ($materiIds as $materiId) {
                MateriHafalan::firstOrCreate([
                    'kelas_id'  => $kelasId,
                    'materi_id' => $materiId,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Materi hafalan berhasil diperbarui');
    }
  
    public function show($id)
    {
        
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
        $rencana = MateriHafalan::findOrFail($id);
        $rencana->delete();

        return redirect()->back()->with('success', 'Materi hafalan berhasil dihapus');
    }
}