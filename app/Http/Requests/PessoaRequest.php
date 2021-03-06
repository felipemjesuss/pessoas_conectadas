<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PessoaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'nome' => 'required',
            'foto' => 'required:image',
            'email' => 'nullable|email|unique:pessoas',
            'localidade' => 'required'
        ];

        if ($this->id) {
            $rules['foto'] = 'image';
            $rules['email'] .= ',email,' . $this->id;
        }

        return $rules;
    }
}
