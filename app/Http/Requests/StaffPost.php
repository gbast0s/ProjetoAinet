<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffPost extends FormRequest
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
            'email' => [
                'required',
                'email',
                (!is_null($this->staff)) ? Rule::unique('users', 'email')->ignore($this->staff->id) : Rule::unique('users', 'email'),
            ],            
            'tipo' =>                   'required',
            'password' =>               'required',
            'foto' =>                   'image|max:8192',   // Máximum size = 8Mb
        ];
    }
}
