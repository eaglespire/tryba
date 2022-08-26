<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
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
            'card_type' => 'required|string',
            'kba_question' => 'required|string',
            'kba_answer' => 'required|string',
            'user_id'   => 'required|exists:users,id',
            'first_name'   => 'required|string',
            'last_name'   => 'required|string',
            'accountId' => 'required|exists:banking_details,accountId',
            'dob'   => 'required|date',
            'email' => 'required|email',
            'phone' => 'required|string',
        ];
    }

    // Messages
    public function messages()
    {
        return [
            'card_type' => 'required|string',
            'kba_question' => 'required|string',
            'kba_answer' => 'required|string',
            'user_id'   => 'required|exists:users,id',
            'first_name'   => 'required|string',
            'last_name'   => 'required|string',
            'accountId.required' => 'A Tryba bank account is required to use this service',
            'accountId.exists' => 'A Tryba bank account is required to use this service',
            'dob.required'   => 'Date of birth is required',
            'dob.date'   => 'Date of birth must be a date',
            'email.required' => 'Enter email address',
            'email.email' => 'Enter a valid email address',
            'phone.required' => 'Enter phone number',
            'phone.string' => 'Phone number must be string',
        ];
    }
}
