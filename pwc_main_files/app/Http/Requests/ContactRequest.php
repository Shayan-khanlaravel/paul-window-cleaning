<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        return
        [
			'name' => 'sometimes',
			'email' => 'sometimes',
			'phone' => 'sometimes',
			'subject' => 'sometimes',
			'property_status' => 'sometimes',
			'address' => 'sometimes',
			'street_number' => 'sometimes',
			'city' => 'sometimes',
			'zip_code' => 'sometimes',
			'message' => 'sometimes',
        ];
    }
}
