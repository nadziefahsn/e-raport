<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class KriteriaPenilaianStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
 @return array<string,
    
    public function rules(): array
    {
        return [
        'kriteria' => 'required',
        'deskripsi' => 'required',
        ];
    }
}
