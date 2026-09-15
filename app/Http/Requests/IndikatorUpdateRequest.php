<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndikatorUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $indikator = $this->route('indikator');
        $indikatorId = is_object($indikator) ? $indikator->id : $indikator;

        return [
            'capaian_perkembangan_id' => 'required|exists:capaians,id',
            'kode'                    => ['required','string', Rule::unique('indikators', 'kode')->ignore($indikatorId),],
            'nama_indikator'          => 'required|string|max:255',
            'jenjang'                 => 'required|string|max:255',
            'tahun_ajaran_id'         => 'required|exists:tahun_ajarans,id',
        ];
    }

    public function messages(): array
    {
        return [
            'kode.unique' => 'Kode sudah tersedia, gunakan kode lain.',
        ];
    }
}