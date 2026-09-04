<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KarakterUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('karakter');
        
        $karakterId = $id instanceof \App\Models\Karakter ? $id->id : $id;

        return [
            'id' => ['required', 'string', 'max:10', 'unique:karakters,id,' . $karakterId . ',id'],
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