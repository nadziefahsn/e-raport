<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class KondisiTubuhStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'guru_id'            => 'nullable',
            'anggota_kelas_id'   => 'required|array',
            'anggota_kelas_id.*' => 'required|exists:anggota_kelases,id',
            'berat_badan'        => 'required|array',
            'berat_badan.*'      => 'nullable|numeric|between:0,999.99',
            'tinggi_badan'       => 'required|array',
            'tinggi_badan.*'     => 'nullable|numeric|between:0,999.99',
        ];
    }
}
