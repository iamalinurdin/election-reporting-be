<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalonRequest extends FormRequest
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
        'no_urut' => 'required|string',
        'nama_calon' =>  'required|string',
        'nama_wakil_calon' => 'required|string',
        'foto_calon' => 'mimes:jpeg,png,jpg,webp',
        'foto_wakil_calon' => 'mimes:jpeg,png,jpg,webp'
      ];
    }
}
