<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\CapaianPerkembangan;
use App\Models\TahunAjaran;
use App\Http\Requests\IndikatorUpdateRequest;
use Illuminate\Support\Facades\DB;


class IndikatorController extends Controller
{
    public function index()
    {
    $tahunAjaranAktif = TahunAjaran::latest()->first();
    $tahunAjarans = TahunAjaran::all();
    $capaians = CapaianPerkembangan::all();

    $indikators = $tahunAjaranAktif 
        ? Indikator::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get() 
        : Indikator::all();

    return view('indikators.index', compact('capaians', 'indikators', 'tahunAjaranAktif', 'tahunAjarans'));
    }

    public function create()
    {
        return view('indikators.index');
    }

    public function store(IndikatorUpdateRequest $request)
    {
        Indikator::create($request->validated());

        return redirect()
            ->route('indikator.index')
            ->with('success', 'Indikator berhasil disimpan.');
    }

    public function show(string $id)
    {
        return view('indikators.index');
    }

    public function edit(string $id)
    {
        $indikator = Indikator::findOrFail($id);
        return view('indikators.index', compact('indikator'));
    }

    public function update(IndikatorUpdateRequest $request, Indikator $indikator)
    {
        $indikator->update($request->validated());

        return redirect()
            ->route('indikator.index')
            ->with('success', 'Indikator berhasil diperbarui.');
    }

    public function destroy(Indikator $indikator)
    {
        $indikator->delete();

        return redirect()
            ->route('indikator.index')
            ->with('success', 'Indikator Berhasil Dihapus!');
    }

    public function duplicateFromPreviousSemester()
    {
        $semesters = TahunAjaran::latest()->take(2)->get();

        if ($semesters->count() < 2) {
            return redirect()->route('indikator.index')
                ->with('error', 'Minimal harus ada 2 data semester (Tahun Ajaran) di sistem untuk melakukan penyalinan.');
        }

        $semesterBaru = $semesters[0];
        $semesterLama = $semesters[1];

        $indikatorSudahAda = Indikator::where('tahun_ajaran_id', $semesterBaru->id)->exists();
        if ($indikatorSudahAda) {
            return redirect()->route('indikator.index')
                ->with('warning', 'Gagal menyalin. Data kelas untuk semester saat ini sudah ada.');
        }

        $indikatorLama = Indikator::where('tahun_ajaran_id', $semesterLama->id)->get();

        if ($indikatorLama->isEmpty()) {
            return redirect()->route('indikator.index')
                ->with('warning', 'Tidak ada data kelas di semester sebelumnya untuk disalin.');
        }

        DB::transaction(function () use ($indikatorLama, $semesterBaru) {
            $dataInsert = [];
            $now = now();

            foreach ($indikatorLama as $item) {
                $dataInsert[] = [
                    'tahun_ajaran_id' => $semesterBaru->id,
                    'capaian_perkembangan_id' => $item->capaian_perkembangan_id,
                    'kode'                    => $item->kode,
                    'nama_indikator'          => $item->nama_indikator,
                    'jenjang'                 => $item->jenjang,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }

            Indikator::insert($dataInsert);
        });

        return redirect()->route('indikator.index')
            ->with('success', 'Data kelas berhasil disalin dari semester sebelumnya.');
    }

    public function importPrevious(IndikatorService $service)
    {
        $result = $service->duplicateFromPreviousSemester();

        return redirect()->route('indikator.index')
        ->with($result['status'], $result['message']);
    }
}