<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GuruUpdateRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }
 @return array<string, ValidationRule|array<mixed>|string>
    
    public function rules(): array
    {
        $guruId = $this->route('guru') ?? $this->id; 

        return [
            'nama_guru'     => 'required|string|max:255',
            'jabatan'       => 'required|string|max:255',
            'nip'           => [
                'required',
                'string',
                'max:255',
            ],
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ];
    }
}
