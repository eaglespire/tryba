<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;
use App\Http\Requests\ApiRequest;

class PaymentRequest extends ApiRequest
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
        $today = Carbon::today();
        return [
            "amount" => "required|numeric|between:0,9999999999.99",
            "payeeAccountNumber" => "required|string|min:8",
            "payeeSortCode" => "required|string|min:6",
            "payeeName"     => "required|string",
            "sourceAccountId" => "string|required",
            "payment_type" => "string|required",
            "account_type" => "string|required",
            "payment_date" => "sometimes|after:$today",
            "user_id"   => "required|exists:users,id",
            "beneficiaryId" => "required"
        ];
    }

    public function messages() {
        return [
            "amount.required" => "Enter an amount",
            "payeeAccountNumber.required" => "Account number is required",
            "payeeAccountNumber.required" => "Account number is required",
            "payeeSortCode.required" => "Sort code is required",
            "payeeSortCode.numeric" => "Sort code must be numeric",
            "payeeName.required"     => "Payee Name is required",
            "payeeName.string"     => "Payee Name must string",
            "sourceAccountId.required" => "Source account is required",
            "payment_type.string" => "Payment type must be string",
            "payment_type.required" => "Payment type is required",
            "account_type.required" => "Account type is required",
            "account_type.string" => "Account type must be string",
            "user_id.required"   => "User Id is required"
        ];
    }
}
