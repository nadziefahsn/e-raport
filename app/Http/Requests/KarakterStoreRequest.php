<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KarakterStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'id' => ['required', 'string', 'max:10', 'unique:karakters,id'],
            'karakter' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'id.unique' => 'Kode karakter sudah tersedia, gunakan kode lain.',
        ];
    }
}


