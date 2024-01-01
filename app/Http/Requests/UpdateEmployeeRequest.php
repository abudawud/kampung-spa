<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
        return [
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::unique(Employee::class, 'email')->ignore($this->employee->id),
            ]
        ] + Employee::VALIDATION_RULES;
    }

    public function messages()
    {
        return Employee::VALIDATION_MESSAGES;
    }
}
