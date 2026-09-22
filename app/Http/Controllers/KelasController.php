<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Requests\KelasUpdateRequest;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
   
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::latest()->first();
        $kelas = Kelas::with(['waliKelas','pendamping','tahunAjaran'])->whereTahunAjaranId($tahunAjaranAktif->id)->get();
        $gurus = Guru::all();
        $tahunAjarans = TahunAjaran::latest()->first();
        
        return view('kelas.index', compact('kelas','gurus','tahunAjarans'));
    }

   
    public function create()
    {
        return view('kelas.index');
    }

    public function store(KelasUpdateRequest $request)
    {
        Kelas::create($request->validated());

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    
    public function show(string $id)
    {
        return view('kelas.index');
    }

    public function edit(string $id)
    {
        
        return view('kelas.index', compact('Kelas'));
    }

    public function update(KelasUpdateRequest $request, Kelas $kelas)
    {
        $kelas->update($request->validated());

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy(Kelas $kelas)
    {
        $kelas->delete($kelas);
        return redirect()->route('kelas.index')
        ->with('success', 'Kelas Berhasil Dihapus!');
    }

    public function duplicateFromPreviousSemester()
    {
        $semesters = TahunAjaran::latest()->take(2)->get();

        if ($semesters->count() < 2) {
            return redirect()->route('kelas.index')
                ->with('error', 'Minimal harus ada 2 data semester (Tahun Ajaran) di sistem untuk melakukan penyalinan.');
        }

        $semesterBaru = $semesters[0];
        $semesterLama = $semesters[1];

        $kelasSudahAda = Kelas::where('tahun_ajaran_id', $semesterBaru->id)->exists();
        if ($kelasSudahAda) {
            return redirect()->route('kelas.index')
                ->with('warning', 'Gagal menyalin. Data kelas untuk semester saat ini sudah ada.');
        }

        $kelasLama = Kelas::where('tahun_ajaran_id', $semesterLama->id)->get();

        if ($kelasLama->isEmpty()) {
            return redirect()->route('kelas.index')
                ->with('warning', 'Tidak ada data kelas di semester sebelumnya untuk disalin.');
        }

        DB::transaction(function () use ($kelasLama, $semesterBaru) {
            $dataInsert = [];
            $now = now();

            foreach ($kelasLama as $item) {
                $dataInsert[] = [
                    'tahun_ajaran_id' => $semesterBaru->id,
                    'rombel'      => $item->rombel,
                    'wali_kelas_id'   => $item->wali_kelas_id,
                    'pendamping_id'   => $item->pendamping_id,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }

            Kelas::insert($dataInsert);
        });

        return redirect()->route('kelas.index')
            ->with('success', 'Data kelas berhasil disalin dari semester sebelumnya.');
    }

    public function importPrevious(KelasService $service)
    {
        $result = $service->duplicateFromPreviousSemester();

        return redirect()->route('kelas.index')
        ->with($result['status'], $result['message']);
    }

}
