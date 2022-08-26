<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ApiRequest;
use Carbon\Carbon;

class ComplianceRequest extends ApiRequest
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
        $before = Carbon::today()->subYears(17);
        return [
            "user_id" => "required|exists:users,id",
            // "business_name" => "required|string",
            // "business_type" => "required|string",
            // "address_line1" => "required|string",
            // "address_line2" => "sometimes|string",
            "dob"       => "required|date|before:$before",
            // "post_town" => "required|string|min:5",
            // "postal_code" => "required|string",
            // "company_reg_number" => "sometimes|string",
            // "country_code" => "required|string",
        ];
    }

    public function messages() {
        return [
            "user_id.required"        => "Enter a user ID",
            "user_id.exists"          => "This user doesn't match any record in our database",
            "business_type.required"  => "Enter your type of business",
            "business_type.string"    => "Business type must be string",
            "business_name.required"  => "Enter your business name",
            "business_name.string"    => "Business name must be string",
            "address_line1.required"  => "Enter your business address",
            "address_line1.string"    => "Address must be string",
            "address_line2.string"    => "Address must be string",
            "postal_code.required"    => "Enter postal code",
            "postal_code.string"      => "Postal code not valid",
            "post_town.required"      => "Enter state/province",
            "post_town.string"        => "State/Province must be alphabet",
            "dob.required"            => "Enter date of birth",
            "dob.date"                => "Date of birth must be a date",
            "dob.before"              => "Date of birth must be an older date",
            "country_code.required"   => "Select country of residense",
            "country_code.string"     => "Country should be alphabetic"
        ];
    }
}
