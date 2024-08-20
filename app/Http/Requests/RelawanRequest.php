<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RelawanRequest extends FormRequest
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
        return [
            //
            'id_posko' => 'required|numeric',
            'id_tps' => 'required|numeric',
            'nama'         => 'required|string',
            'alamat'      => 'required|string',
            'no_handphone'      => 'required|string',
        ];
    }
}
