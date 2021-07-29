<?php

namespace App\Http\Requests;

use App\Models\Cores;
use App\Models\Tshirts;
use Illuminate\Foundation\Http\FormRequest;

class CarrinhoPost extends FormRequest
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
            'tam' => 'required',
            'cor' =>['required', function ($attribute, $value, $fail) {

                $size = Cores::where('codigo', $value)->exists();
                if (!$size) {
                    $fail('The '.$attribute.' is invalid.');
                }}],
            'quantidade' =>           'required|numeric|min:1|max:20',
        ];
    }
    // 'tam' =>['required', function ($attribute, $value, $fail) {

    //     $size = Tshirts::where('tamanho', $value)->exists();
    //     if (!$size) {
    //         $fail('The '.$attribute.' is invalid.');
    //     }}],
}
