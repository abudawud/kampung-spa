<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Site;
use Illuminate\Validation\Rule;

class UpdateSiteRequest extends FormRequest
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
            'city_code' => [
                'required',
                Rule::unique(Site::class, 'city_code')->ignore($this->site->id),
            ]
        ] + Site::VALIDATION_RULES;
    }

    public function messages()
    {
        return Site::VALIDATION_MESSAGES;
    }
}
