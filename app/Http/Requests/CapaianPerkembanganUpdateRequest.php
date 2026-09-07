<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CapaianPerkembanganUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

 @return array<string, ValidationRule|array<mixed>|string>
    
    public function rules(): array
    {
        return [
            'capaian_perkembangan' => 'required|string|max:255',
        ];
    }
}
