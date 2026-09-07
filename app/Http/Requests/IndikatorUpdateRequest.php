<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IndikatorUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

 @return array<string, ValidationRule|array<mixed>|string>
    
    public function rules(): array
    {
        return [
            'capaian_perkembangan_id' => 'required|exists:capaians,id',
            'kode' => 'required|string|max:255',
            'nama_indikator' => 'required|string|max:255',
            'jenjang' => 'required|string|max:255',
            'tahun_ajaran_id' => 'required|exists:tahun_ajarans,id',
        ];
    }
}
