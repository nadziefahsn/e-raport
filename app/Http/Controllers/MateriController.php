<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use App\Models\Hafalan;
use App\Models\TahunAjaran;
use App\Http\Requests\MateriRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MateriImport;

class MateriController extends Controller
{
    public function importForm()
    {
        return view('materis.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'file.required' => 'File Excel wajib diunggah!',
            'file.mimes'    => 'Format file harus .xlsx, .xls, atau .csv!',
            'file.max'      => 'Ukuran file maksimal 2MB!',
        ]);

        Excel::import(new MateriImport, $request->file('file'));

        return redirect()->route('materi.index')->with('success', 'Data materi berhasil di-import!');
    }

    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::latest()->first();
        $tahunAjarans = TahunAjaran::all();
        $hafalans = Hafalan::all();

        $materi = $tahunAjaranAktif 
            ? Materi::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get() 
            : Materi::all();

        return view('materis.index', compact('hafalans', 'materi', 'tahunAjaranAktif', 'tahunAjarans'));

    }

    public function create()
    {
        return view('materis.index');
    }

    public function store(MateriRequest $request)
    {
        Materi::create($request->validated());

        return redirect()
            ->route('materi.index')
            ->with('success', ' Data materi berhasil disimpan.');
    }

    public function show(string $id)
    {
        return view('materis.index');
    }

    public function edit(string $id)
    {
        $materi = Materi::findOrFail($id);
        return view('materis.index', compact('materi'));
    }

    public function update(MateriRequest $request, Materi $materi)
    {
        $materi->update($request->validated());

        return redirect()
            ->route('materi.index')
            ->with('success', ' Data materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        $materi->delete();

        return redirect()
            ->route('materi.index')
            ->with('success', 'Data materi Berhasil Dihapus!');
    }

        public function duplicateFromPreviousSemester()
    {
        $semesters = TahunAjaran::latest()->take(2)->get();

        if ($semesters->count() < 2) {
            return redirect()->route('materi.index')
                ->with('error', 'Minimal harus ada 2 data semester (Tahun Ajaran) di sistem untuk melakukan penyalinan.');
        }

        $semesterBaru = $semesters[0];
        $semesterLama = $semesters[1];

        $materiLama = Materi::where('tahun_ajaran_id', $semesterLama->id)->get();

        if ($materiLama->isEmpty()) {
            return redirect()->route('materi.index')
                ->with('warning', 'Tidak ada data materi di semester sebelumnya untuk disalin.');
        }

        DB::transaction(function () use ($materiLama, $semesterBaru) {
            $dataInsert = [];
            $now = now();

            foreach ($materiLama as $item) {
                $dataInsert[] = [
                    'tahun_ajaran_id' => $semesterBaru->id,
                    'capaian_hafalan_id' => $item->capaian_hafalan_id,
                    'kode'                    => $item->kode,
                    'nama_materi'          => $item->nama_materi,
                    'jenjang'                 => $item->jenjang,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }

            Materi::insert($dataInsert);
        });

        return redirect()->route('materi.index')
            ->with('success', 'Data materi berhasil disalin dari semester sebelumnya.');
    }

    public function importPrevious(MateriService $service)
    {
        $result = $service->duplicateFromPreviousSemester();

        return redirect()->route('materi.index')
        ->with($result['status'], $result['message']);
    }
}
