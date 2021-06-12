<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientesPost extends FormRequest
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
        return [
            'name' =>                   'required',
            'nif' =>                    'required|digits:9',
            'endereco' =>               'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user()->id),
            ],             
            'tipo_pagamento' =>         'required',
            'ref_pagamento' =>          ($this->tipo_pagamento == 'PAYPAL' ? 'required|email' : 'required|digits:16'),
            'foto' =>                   'image|max:8192',   // Máximum size = 8Mb
        ];
    }
}
