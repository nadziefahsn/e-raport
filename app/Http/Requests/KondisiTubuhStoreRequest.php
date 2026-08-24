<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class KondisiTubuhStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
        return [
            'kondisi'                    => 'required|array',
            'kondisi.*.anggota_kelas_id' => 'required|exists:anggota_kelases,id',
            'kondisi.*.berat_badan'      => 'nullable|numeric|between:0,999.99',
            'kondisi.*.tinggi_badan'     => 'nullable|numeric|between:0,999.99',
        ];
    }
}
