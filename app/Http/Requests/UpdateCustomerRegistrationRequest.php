<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\CustomerRegistration;

class UpdateCustomerRegistrationRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return CustomerRegistration::VALIDATION_RULES;
    }

    public function messages()
    {
        return CustomerRegistration::VALIDATION_MESSAGES;
    }
}
