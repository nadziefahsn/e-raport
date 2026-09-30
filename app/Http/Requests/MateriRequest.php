<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MateriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $materi = $this->route('materi');
        $materiId = is_object($materi) ? $materi->id : $materi;

        return [
            'capaian_hafalan_id' => 'required|exists:hafalans,id',
            'kode'                    => ['required','string', Rule::unique('materi', 'kode')->ignore($materiId),],
            'nama_materi'          => 'required|string|max:255',
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
