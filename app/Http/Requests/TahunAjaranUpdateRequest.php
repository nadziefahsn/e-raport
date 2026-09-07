<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TahunAjaranUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
     
    public function rules(): array
    {
        return [
            'tahun_ajaran' => ['required', 'string'],
            'semester' => ['required', 'in:1,2'],
        ];
    }
}
