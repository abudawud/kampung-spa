<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PackageItem;
use Illuminate\Validation\Rule;

class StorePackageItemRequest extends FormRequest
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
            'items.*' => Rule::unique(PackageItem::class, 'item_id')->where('package_id', $this->package->id)
        ] + PackageItem::VALIDATION_RULES;
    }

    public function messages()
    {
        return PackageItem::VALIDATION_MESSAGES;
    }
}
