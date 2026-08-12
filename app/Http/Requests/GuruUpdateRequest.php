<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GuruUpdateRequest extends FormRequest
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
        $guruId = $this->route('guru') ?? $this->id; 

        return [
            'nama_guru'     => 'required|string|max:255',
            'jabatan'       => 'required|string|max:255',
            'nip'           => 'required|numeric|unique:gurus,id,' . $guruId, 
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        ];
    }

        public function messages(): array
    {
        return [
            'nip.unique' => 'NIP ini sudah digunakan oleh guru lain!',
        ];
    }
}