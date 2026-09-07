<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TahunAjaranStoreRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
 @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     
    public function rules(): array
    {
        return [
            'tahun_ajaran' => ['required', 'string'],
            'semester' => ['required', 'in:1,2'],
        ];
    }
}
