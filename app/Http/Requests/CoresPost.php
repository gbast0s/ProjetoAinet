<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CoresPost extends FormRequest
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
            // store rules here - require image here
            return [
            'nome' =>               'required',           
            'codigo' => [
                'required',
                'regex:/^#?(([a-f0-9]{3}){1,2})$/i',
                (!is_null($this->cor)) ? Rule::unique('cores', 'codigo')->ignore($this->cor->codigo, 'codigo') : Rule::unique('cores', 'codigo'),
            ], 
            'foto' =>               'required|image|max:8192|dimensions:width=520,height=560',
        ];
        
    }
}
