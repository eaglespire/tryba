<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class personal extends FormRequest
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
        'postal_or_zipcode' => 'required|alpha_num',
        'state' => 'required|alpha_num',
        'address_one'=>'required|alpha_dash',
        'address_two'=>'required|alpha_dash'
        ];
    }
}
