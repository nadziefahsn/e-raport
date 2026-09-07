<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class NilaiKarakterUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
 @return array<string, ValidationRule|array<mixed>|string>
    
    public function rules(): array
    {
        return [
            'guru_id' => 'nullable',
            'nilai' => 'nullable|array',
            'nilai.*.*' => 'nullable|in:T, TT',
        ];
    }
}
