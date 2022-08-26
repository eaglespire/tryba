<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class AddBeneficiaryRequest extends ApiRequest
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
            'cid' => 'required|string|exists:banking_details,customerId',
            'uid' => 'required|string|exists:users,id',
            'accountNumber' => 'required|string',
            'sortCode'  => 'required|string',
            'beneficiaryName' => 'required|string'
        ];
    }

    public function messages() {
        return [
            'uid.required' => 'Enter user ID',
            'uid.exists' => 'User not found on Tryba systems',
            'cid.required' => 'Enter customer ID',
            'cid.string' => 'Customer ID must be string',
            'cid.exists' => 'Customer not found on Tryba systems',
            'accountNumber.required' => 'Enter beneficiary account number',
            'accountNumber.string' => 'Account number must be string',
            'sortCode.string' => 'Sort code must be string',
            'sortCode.required' => 'Enter Sort code',
            'beneficiaryName.required' => 'Beneficiary Name',
            'beneficiaryName.string' => 'Beneficiary Name must be string',
        ];        
    }
}
