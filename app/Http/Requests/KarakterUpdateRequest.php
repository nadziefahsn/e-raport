<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\TahunAjaran;

class KarakterUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $karakter = $this->route('karakter');
        
        $karakterId = $karakter instanceof \App\Models\Karakter ? $karakter->id : $karakter;
        
        if ($karakter instanceof \App\Models\Karakter) {
            $tahunAjaranId = $karakter->tahun_ajaran_id;
        } else {
            $tahunAjaranAktif = TahunAjaran::latest()->first();
            $tahunAjaranId = $tahunAjaranAktif ? $tahunAjaranAktif->id : null;
        }

        return [
            'kode' => [
                'required',
                'string',
                'max:10',
                Rule::unique('karakters', 'kode')
                    ->where(function ($query) use ($tahunAjaranId) {
                        return $query->where('tahun_ajaran_id', $tahunAjaranId);
                    })
                    ->ignore($karakterId),
            ],
            'karakter' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode.unique' => 'Kode karakter sudah digunakan pada tahun ajaran ini.',
        ];
    }
}