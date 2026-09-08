<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class KriteriaPenilaianUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'kriteria'  => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ];
    }
}
