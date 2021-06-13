<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoresPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if(request()->isMethod('put')) // could be patch as well
        {
             // Update rules here - Don't require image here
             return [
                'name' =>                   'required',           
                'codigo' =>                 'required|regex:/^#?(([a-f0-9]{3}){1,2})$/i',
                'password' =>               'nullable',
                'foto' =>                   'image|max:8192',   // Máximum size = 8Mb
            ];

        }else{
             // store rules here - require image here
             return [
                'name' =>                   'required',           
                'codigo' =>                 'required|regex:/^#?(([a-f0-9]{3}){1,2})$/i',
                'password' =>               'required',
                'foto' =>                   'image|max:8192',   // Máximum size = 8Mb
            ];
        }
    }
}
