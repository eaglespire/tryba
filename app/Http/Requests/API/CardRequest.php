<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class CardRequest extends ApiRequest
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
            'accountId'   => 'required|exists:banking_details,accountId',
        ];
    }

    // Messages
    public function messages()
    {
        return [
            'card_type.required' => 'Select Card Type',
            'card_type.string' => 'Card type mustbe string',
            'kba_question.required' => 'Select a security question',
            'kba_question.required' => 'Security question must be string',
            'kba_answer.required' => 'Enter an answer for your security question',
            'kba_answer.string' => 'Answer must be string',
            'user_id.required'   => 'No user selected',
            'user_id.exists'   => 'Selected user is not a Tryba customer',
            'accountId.required'   => 'Selct bank account',
            'accountId.exists'   => 'Selected bank account does not exist on Tryba',
        ];
    }
}
