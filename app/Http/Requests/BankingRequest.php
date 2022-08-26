<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;

class BankingRequest extends ApiRequest
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
            'user_id' => 'required|integer',
            'companyName' => 'sometimes|string',
            'accountType' => 'required|string',
            'company_regNumber' => 'sometimes|string',
            'dob' => 'required',
            'industryCode' => 'required|string',
            'addressLin1' => 'required|string',
            'addressLin2' => 'sometimes|string',
            'postCode' => 'required|string',
            'postTown' => 'required|string',
        ];
    }

    public function messages() {
        return [
            'user_id.required' => 'user ID must be an integer',
            'companyName.string' => 'Please enter a company name',
            'accountType.required' => 'Select an account type',
            'accountType.string' => 'Account type must be string',
            'company_regNumber.string' => 'Company registraion number must be string',
            'dob.required' => 'Enter date of birth',
            'industryCode.string' => 'Industry code must be string',
            'industryCode.required' => 'Enter industry code',
            'addressLin1.required' => 'Enter an address',
            'addressLin1.string' => 'Address must be string',
            'addressLin2.string' => 'Address must be string',
            'postCode.required' => 'Enter post code',
            'postTown..required' => 'Enter post town',

        ];
    }
}
