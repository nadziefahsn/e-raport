<?php

namespace App\Http\Controllers;

use App\Models\Karakter;
use App\Models\TahunAjaran;
use App\Http\Requests\KarakterUpdateRequest;
use Illuminate\Support\Facades\DB;

class KarakterController extends Controller
{
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::latest()->first();
        $karakters = $tahunAjaranAktif 
            ? Karakter::where('tahun_ajaran_id', $tahunAjaranAktif->id)->get() 
            : Karakter::all();

        return view('karakters.index', compact('karakters', 'tahunAjaranAktif'));
    }

    public function create()
    {
        return view('karakters.index');
    }

    public function store(KarakterUpdateRequest $request)
    {
        $data = $request->validated();

        $tahunAjaranAktif = TahunAjaran::latest()->first();
        if ($tahunAjaranAktif) {
            $data['tahun_ajaran_id'] = $tahunAjaranAktif->id;
        }

        Karakter::create($data);

        return redirect()
            ->route('karakter.index')
            ->with('success', 'Data karakter berhasil disimpan.');
    }

    public function show(string $id)
    {
        return view('karakters.index');
    }

    public function edit(string $id)
    {
        $karakter = Karakter::findOrFail($id);
        return view('karakters.index', compact('karakter'));
    }

    public function update(KarakterUpdateRequest $request, Karakter $karakter)
    {
        $data = $request->validated();

        $karakter->update($data);

        return redirect()
            ->route('karakter.index')
            ->with('success', 'Data karakter berhasil diperbarui.');
    }

    public function destroy(Karakter $karakter)
    {
        $karakter->delete();

        return redirect()
            ->route('karakter.index')
            ->with('success', 'Data karakter berhasil dihapus.');
    }

    public function duplicateFromPreviousSemester()
    {
        $semesters = TahunAjaran::latest()->take(2)->get();

        if ($semesters->count() < 2) {
            return redirect()->route('karakter.index')
                ->with('error', 'Minimal harus ada 2 data semester (Tahun Ajaran) di sistem untuk melakukan penyalinan.');
        }

        $semesterBaru = $semesters[0];
        $semesterLama = $semesters[1];

        $karakterSudahAda = Karakter::where('tahun_ajaran_id', $semesterBaru->id)->exists();
        if ($karakterSudahAda) {
            return redirect()->route('karakter.index')
                ->with('warning', 'Gagal menyalin. Data karakter untuk semester saat ini sudah ada.');
        }

        $karakterLama = Karakter::where('tahun_ajaran_id', $semesterLama->id)->get();

        if ($karakterLama->isEmpty()) {
            return redirect()->route('karakter.index')
                ->with('warning', 'Tidak ada data karakter di semester sebelumnya untuk disalin.');
        }

        DB::transaction(function () use ($karakterLama, $semesterBaru) {
            $dataInsert = [];
            $now = now();

            foreach ($karakterLama as $item) {
                $dataInsert[] = [
                    'kode'            => $item->kode,
                    'karakter'        => $item->karakter,
                    'tahun_ajaran_id' => $semesterBaru->id,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            }

            Karakter::insert($dataInsert);
        });

        return redirect()->route('karakter.index')
            ->with('success', 'Data karakter berhasil disalin dari semester sebelumnya.');
    }

    public function importPrevious(KarakterService $service)
    {
        $result = $service->duplicateFromPreviousSemester();

        return redirect()->route('karakter.index')
            ->with($result['status'], $result['message']);
    }
}